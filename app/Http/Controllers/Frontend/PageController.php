<?php

namespace App\Http\Controllers\Frontend;

use App\Models\About;
use App\Models\Brand;
use App\Models\Story;
use App\Models\Contact;
use App\Models\Language;
use App\Models\Partners;
use App\Post\PostInterface;
use App\Facts\FactInterface;
use Illuminate\Http\Request;
use App\Stories\StoryInterface;
use App\Services\ContactService;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;

class PageController extends Controller
{
    protected $data;

    protected $stories;

    protected $anonymous_posts;

    public function __construct(FactInterface $data, StoryInterface $stories, PostInterface $anonymous_posts)
    {
        $this->data  = $data;
        $this->stories = $stories;
        $this->anonymous_posts = $anonymous_posts;
    }

    public function home()
    {
        $languages = Language::where('status', 1)->get();
        $anonymous_post_one = $this->anonymous_posts->getPost(1);
        $anonymous_post_two = $this->anonymous_posts->getPost(2);

        $sliders = $this->data->getData('banner-slider');
        $facts = $this->data->getData('facts');
        $brands = $this->data->getData('brand-section');
        $stories = $this->data->getData('story-section');

        $slider_content = '';
        if ($sliders) {
            $slider_content = json_decode($sliders->block_content);
            if ($slider_content->content[0]) {
                $slider_content = $slider_content->content[0];
            }
        }

        return view(
            'frontend.home.index',
            compact(
                'languages',
                'sliders',
                'slider_content',
                'anonymous_post_one',
                'anonymous_post_two',
                'facts',
                'brands',
                'stories'
            )
        );
    }

    public function About()
    {
        $abouts = About::where('is_published', 1)->get();
        $brands = Brand::where('is_published', 1)->get();
        //$brands = $this->data->getData('brand-section');
        $partners = Partners::where('is_published', 1)->get();
        return view('frontend.home.about', compact('abouts', 'brands', 'partners'));
    }

    public function Brands()
    {
        $brands = Brand::where('is_published', 1)->get();
        return view('frontend.home.brands', compact('brands'));
    }

    public function Stories()
    {
        //dd(app()->getLocale());
        $stories = $this->stories->getData(0); //For All
        $insights = $this->stories->getData(1); // For Insight Category
        $manufacturings = $this->stories->getData(2); //For Manufacturing category
        $reasearchs = $this->stories->getData(3); //For Reearch category
        $feature_stories = Story::where('is_published', 1)->where('feature', 1)->get(); //For feature stories
        $header = Story::where('is_published', 1)->where('header', 1)->first(); //For Header Stories

        return view('frontend.home.stories', compact('stories', 'feature_stories', 'header', 'insights', 'manufacturings', 'reasearchs'));
    }
    public function Partners()
    {
        $partners = Partners::where('is_published', 1)->get();
        return view('frontend.home.partners', compact('partners'));
    }

    public function Facts()
    {
        return view('frontend.home.facts');
    }

    public function Contact()
    {
        return view('frontend.home.contact');
    }

    public function saveContact(ContactRequest $request)
    {
        $response = ContactService::SaveContact($request);
        if ($response) {
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Contact save successfully'
                ]
            );
        } else {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Failed to contact save'
                ]
            );
        }
    }
}
