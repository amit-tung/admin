    @component('admin.component.select', [
        'name' => 'app_id',
        'title' => 'App',
        'lists' => \App\Models\App::get()->pluck('name','id'),
        'value'=>null,
        'required'=>true,
        'options'=>['placeholder'=>'Select App ','id'=>"app_id"]
    ])@endcomponent
    @component('admin.component.select', [
        'name' => 'business_category_id',
        'title' => 'Select Business Category',
        'lists' => App\Models\BusinessCategory::all()->pluck('name','id'),
        'value'=>null,
        'required'=>true,
        'options'=>['placeholder'=>'Select Business Category ','id'=>"business_category_id"]
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
       'lists' => \App\Models\VideoCategory::$languages,
       'value'=>null,
       'required'=>true,
       'options'=>['placeholder'=>'Enter language']
   ])@endcomponent
  @component('admin.component.file', [
    'name' => 'media',
    'title' => 'Upload Media',
    'value'=>null,
    'required'=>true,
    'options'=>['placeholder'=>'Choose file']
    ])@endcomponent

    @component('admin.component.select', [
    'name' => 'media_type',
    'title' => 'Select Media Type (Image/Vidoe)',
    'lists' =>['image'=>'Image','video'=>'Video'],
    'value'=>null,
    'required'=>true,
    'options'=>['placeholder'=>'Select Media Type']
    ])@endcomponent


    @if(!empty($record['image_url']))
    <img src="{{ $record['image_url'] }}" width="150">
    @endif
