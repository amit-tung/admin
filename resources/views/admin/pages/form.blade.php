
    @component('admin.component.text', [
        'name' => 'name',
        'title' => 'Name',
        'value'=>null,
        'required'=>true,
        'options'=>['placeholder'=>'Enter name']
    ])@endcomponent
    @component('admin.component.text', [
       'name' => 'slug',
       'title' => 'Slug',
       'value'=>null,
       'required'=>true,
       'options'=>['placeholder'=>'Enter slug']
   ])@endcomponent
    @component('admin.component.textarea', [
       'name' => 'detail',
       'title' => 'Detail',
       'value'=>null,
       'required'=>true,
       'options'=>['placeholder'=>'Enter detail']
   ])@endcomponent


    {{--@if(!empty($record['image_url']))
    <img src="{{ $record['image_url'] }}" width="150">
    @endif
--}}