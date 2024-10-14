Dear {{$data->task_owner}},<br><br>
The Tasks{{$data->task_description}},<br><br> {{ $data->status == 0?"Has been added for you": "Has been marked as complete"}}<br><br>


@if($data->status==0)
Kindly complete it winthin {{$data->task_eta}},<br><br>
@endif


Thank you