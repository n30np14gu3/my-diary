<div class="ui stackable four column equal width grid">
    <div class="sixteen wide column">
        <div class="ui text content center aligned container">
            <div class="ui huge positive button" onclick="showModal('modal-compose-form')">Compose <i class="right arrow icon"></i></div>
        </div>
    </div>
    @foreach(@$data['notes'] as $n)
        <div class="column">
            <div class="ui fluid card">
                <div class="content">
                    <div class="header">{{@$n->title}}</div>
                    <div class="header" style="font-size: 12px">{{@$n->created_at}}</div>
                </div>
                <div class="extra content">
                    <a class="ui positive fluid button" href="{{url('/note/'.@$n->id)}}" target="_blank">Read Note</a>
                </div>
            </div>
        </div>
    @endforeach
</div>
