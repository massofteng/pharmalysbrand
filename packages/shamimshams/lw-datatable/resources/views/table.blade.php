<table {{ $attributes->merge(["class" => "table"]) }}>
    @if(isset($thead))
    <thead>
        {{ $thead }}
    </thead>
    @endif

    @if(isset($tbody))
    <tbody>
        {{ $tbody }}
    </tbody>
    @endif

    @if(isset($tfoot))
    <tfoot>
        {{ $tfoot }}
    </tfoot>
    @endif
</table>