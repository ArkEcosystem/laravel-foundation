<a
    href="{{ config('web.github_source') }}/tree/master/{{$document->type}}/{{$document->slug}}.md.blade.php"
    target="_blank"
    rel="noopener nofollow noreferrer"
    class="pl-5 flex items-center space-x-3 link font-semibold"
>
    @svg('pencil', 'h-4 w-4')
    <span>@lang('ui::actions.docs.edit_page')</span>
</a>
