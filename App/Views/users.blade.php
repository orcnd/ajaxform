<div class="row" hx-trigger="every 15s" hx-get="/?page=users" hx-swap="outerHTML">
    <div class="col">
        <table class="table table-striped table-hover table-bordered ">
            <thead>
                <tr>
                    <th>Avatar</th>
                    <th>Name</th>
                    <th>E-Mail</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $user)
                    <tr class="align-middle"  style="height:64px;">
                        <td style="width:64px;">
                            @if($user->avatar!==null)
                            <img src="/Avatars/{{$user->avatar}}"
                                style="max-height:64px"
                                class="rounded-end-circle float-start w-100" alt="{{$user->name}}">
                            @endif
                        </td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <hr>
        <button hx-target="#container" hx-get="?page=welcome" hx-swap="innerHTML" class="btn btn-secondary w-100"><< Back <<</button>
    </div>
</div>