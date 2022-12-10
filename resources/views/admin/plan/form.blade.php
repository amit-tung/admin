    @component('admin.component.text', [
        'name' => 'contact',
        'title' => 'Contact No.',
        'value'=>null,
        'required'=>true,
        'options'=>['placeholder'=>'Enter Contact No.']
    ])@endcomponent

    @component('admin.component.text', [
        'name' => 'days',
        'title' => 'Days',
        'value'=>null,
        'required'=>true,
        'options'=>['placeholder'=>'Enter plan days']
    ])@endcomponent

    @component('admin.component.text', [
        'name' => 'plan_amount',
        'title' => 'Plan Amount',
        'value'=>null,
        'required'=>true,
        'options'=>['placeholder'=>'Enter plan amount']
    ])@endcomponent

    @component('admin.component.file', [
       'name' => 'plan_image',
       'title' => 'Upload plan image',
       'value'=>null,
       'required'=>true,
       'options'=>['placeholder'=>'Choose file']
   ])@endcomponent

    @component('admin.component.file', [
        'name' => 'payment_image',
        'title' => 'Upload payment image',
        'value'=>null,
        'required'=>true,
        'options'=>['placeholder'=>'Choose file']
    ])@endcomponent


    @if(!empty($record['plan_image_url']))
    <img src="{{ $record['plan_image_url'] }}" width="150">
    @endif
    @if(!empty($record['payment_image_url']))
        <img src="{{ $record['payment_image_url'] }}" width="150">
    @endif