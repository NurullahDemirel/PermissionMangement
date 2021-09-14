<h1>{{config('app.name')}}</h1>
<p>
    {{$user->name}},Kaydınızı tamamlamak için
    <a href="{{ route('aktif-et',$user->activate_code) }}">
        tıklayınız
    </a>
</p>
