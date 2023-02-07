<?php

namespace ShamimShams\TranslationManager;

use Illuminate\Support\Str;
use Symfony\Component\Finder\Finder;
use ShamimShams\TranslationManager\Models\TranslationManager as TranslationModel;

class MissingTranslations
{
    const JSON_GROUP = '_json';

    public static function find( $path = null )
    {
        $path       = $path ?: base_path();
        $groupKeys  = [];
        $stringKeys = [];
        $functions  = config( 'ltm.trans_functions' );

        $groupPattern =                        // See https://regex101.com/r/WEJqdL/6
        "[^\w|>]" .                            // Must not have an alphanum or _ or > before real method
        '(' . implode( '|', $functions ) . ')' . // Must start with one of the functions
        "\(" .                                 // Match opening parenthesis
        "[\'\"]" .                             // Match " or '
        '(' .                                  // Start a new group to match:
        '[a-zA-Z0-9_-]+' .                     // Must start with group
        "([.](?! )[^\1)]+)+" .                 // Be followed by one or more items/keys
        ')' .                                  // Close group
        "[\'\"]" .                             // Closing quote
        "[\),]";                               // Close parentheses or new parameter

        $stringPattern =
        "[^\w]" .                                       // Must not have an alphanum before real method
        '(' . implode( '|', $functions ) . ')' .          // Must start with one of the functions
        "\(\s*" .                                       // Match opening parenthesis
        "(?P<quote>['\"])" .                            // Match " or ' and store in {quote}
        "(?P<string>(?:\\\k{quote}|(?!\k{quote}).)*)" . // Match any string that can be {quote} escaped
        "\k{quote}" .                                   // Match " or ' previously matched
        "\s*[\),]";

        // Find all PHP + Twig files in the app folder, except for storage
        $finder = new Finder();
        $finder->in( $path )->exclude( 'storage' )->exclude( 'vendor' )->name( '*.php' )->name( '*.twig' )->name( '*.vue' )->files();

        foreach ( $finder as $file ) {
            if ( preg_match_all( "/$groupPattern/siU", $file->getContents(), $matches ) ) {
                foreach ( $matches[2] as $key ) {
                    $groupKeys[] = $key;
                }

            }

            if ( preg_match_all( "/$stringPattern/siU", $file->getContents(), $matches ) ) {

                foreach ( $matches['string'] as $key ) {

                    if ( preg_match( "/(^[a-zA-Z0-9_-]+([.][^\1)\ ]+)+$)/siU", $key, $groupMatches ) ) {
                        continue;
                    }

                    if ( !( Str::contains( $key, '::' ) && Str::contains( $key, '.' ) )
                        || Str::contains( $key, ' ' ) ) {
                        $stringKeys[] = $key;
                    }

                }

            }

        }

        // Remove duplicates
        $groupKeys  = array_unique( $groupKeys );
        $stringKeys = array_unique( $stringKeys );

        return [
            'groupKeys'    => $groupKeys,
            'stringKeys'   => $stringKeys,
            'totalMissing' => count( array_merge( $groupKeys, $stringKeys ) ),
        ];
    }

    public static function missing()
    {
        $allTranslations = self::find();

        $groupGroups = [];
        $groupKeys   = [];

        foreach ( $allTranslations['groupKeys'] as $key ) {
            list( $group, $item ) = explode( '.', $key, 2 );
            $groupGroups[]      = $group;
            $groupKeys[]        = $item;
        }

        $missingGroupKeys = TranslationModel::where( "group", "!=", "*" )->get( ['group', 'key'] )->map( function ( $item ) {
            return "{$item->group}.{$item->key}";
        } );

        $missing['groupKeys'] = array_diff( $allTranslations['groupKeys'], $missingGroupKeys->toArray() );
        $missingStringKeys = TranslationModel::where('group', '*')->pluck('key')->toArray();
        
        $missing['stringKeys'] = array_diff( $allTranslations['stringKeys'], $missingStringKeys );

        $missing['total'] = count(array_merge($missing['groupKeys'], $missing['stringKeys']));

        return $missing;
    }

}
