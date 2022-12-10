    @component('admin.component.select', [
        'name' => 'festival_video_category_id',
        'title' => 'select festival Video category',
        'lists' => App\Model\FestivalVideoCategory::all()->pluck('name','id'),
        'value'=>null,
        'required'=>true,
        'options'=>[]
    ])@endcomponent
    @component('admin.component.text', [
        'name' => 'title',
        'title' => 'Title',
        'value'=>null,
        'required'=>true,
        'options'=>['placeholder'=>'Enter title']
    ])@endcomponent
    @component('admin.component.text', [
       'name' => 'description',
       'title' => 'Description',
       'value'=>null,
       'required'=>true,
       'options'=>['placeholder'=>'Enter description']
   ])@endcomponent
    @component('admin.component.select', [
        'name' => 'language',
        'title' => 'select Language',
        'lists' => \App\Model\VideoCategory::$languages,
        'value'=>null,
        'required'=>true,
        'options'=>['placeholder'=>'Enter language']
    ])@endcomponent
    @component('admin.component.file', [
        'name' => 'video',
        'title' => 'Upload video',
        'value'=>null,
        'required'=>true,
        'options'=>['placeholder'=>'Choose file']
    ])@endcomponent


    @if(!empty($record['video_url']))
    <img src="{{ $record['video_url'] }}" width="150">
    @endif