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
        'name' => 'name',
        'title' => 'Name',
        'value'=>null,
        'required'=>true,
        'options'=>['placeholder'=>'Enter Name']
    ])@endcomponent
    

  @component('admin.component.file', [
    'name' => 'image',
    'title' => 'Upload Image',
    'value'=>null,
    'required'=>true,
    'options'=>['placeholder'=>'Choose file']
    ])@endcomponent


    @if(!empty($record['image_url']))
    <img src="{{ $record['image_url'] }}" width="150">
    @endif
