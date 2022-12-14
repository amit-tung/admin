
    @component('admin.component.text', [
        'name' => 'name',
        'title' => 'Name',
        'value'=>null,
        'required'=>true,
        'options'=>['placeholder'=>'Enter name']
    ])@endcomponent
    {{--@component('admin.component.select', [--}}
        {{--'name' => 'language',--}}
        {{--'title' => 'select Language',--}}
        {{--'lists' => \App\Model\VideoCategory::$languages,--}}
        {{--'value'=>null,--}}
        {{--'required'=>true,--}}
        {{--'options'=>['placeholder'=>'Enter language']--}}
    {{--])@endcomponent--}}
    @component('admin.component.file', [
        'name' => 'image',
        'title' => 'Upload image',
        'value'=>null,
        'required'=>true,
        'options'=>['placeholder'=>'Choose file']
    ])@endcomponent
 @component('admin.component.select', [
    'name' => 'app_id',
    'title' => 'App',
    'lists' => \App\Models\App::get()->pluck('name','id'),
    'value'=>null,
    'required'=>true,
    'options'=>['placeholder'=>'Select App ']
])@endcomponent

    @if(!empty($record['image_url']))
    <img src="{{ $record['image_url'] }}" width="150">
    @endif
