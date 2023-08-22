@extends('backend.layout')
@section('content')
<section class="content-header">
  <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Users</h3>
        @if(Auth::user()->role==0)<div align="right">
          <a href="{{route('user.create')}}"><button class="btn btn-success">Add New</button></a>
        </div>@endif
      </div>
      <div class="box-body">
        <table class="table">
            <thead>
                    <th>Photo</th>
                    <th>Name Surname</th>
                    <th>E-mail</th>
                    <th></th>
                    @if(Auth::user()->role==0)<th></th>
                    <th></th>@endif
             </thead>   
                <tbody>
                  @foreach ($data['user'] as $user)
                    <tr class="table-active {{$user->user_status=="0" ? "bg-danger" : "bg-success"}}" id="item-{{$user->id}}">
                    <td><img width="75" src="/images/users/{{$user->user_file}}"></td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td width="5"><a href="{{route('user.show',$user->id)}}"><i class="fa fa-info-circle fa-lg"></i></a></td>
                    @if(Auth::user()->role==0)<td width="5"><a href="{{route('user.edit',$user->id)}}"><i class="fa fa-pencil-square fa-lg"></i></a></td>
                    <td width="5">
                      <a href="javascript:void(0)"><i id="@php echo $user->id @endphp" class="fa fa-trash-o fa-lg"></i></a></td>@endif
                    </tr>

                  @endforeach
                </tbody>
        </table>
      </div>
  </div>
  </section>

  <script type="text/javascript">
    $(function(){
        $.ajaxSetup({
          headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
      });

    $(".fa-trash-o").click(function () {
      
            destroy_id = $(this).attr('id');

            alertify.confirm('Silme işlemini onaylayın!', 'Bu işlem geri alınamaz',
                function () { 
                  $.ajax({
                    type:"DELETE",
                    url:"user/"+destroy_id,
                    success: function(msg){
                      if(msg)
                      {
                        $("#item-"+destroy_id).remove();
                        alertify.success("Silme İşlemi Başarılı");
                      }
                      else
                      {
                        alertify.error("İşlem Tamamlanamadı");
                      }
                    }

                  });

                },
                function () {
                    alertify.error('Silme işlemi iptal edildi')
                }
            )

        });

  </script>

@endsection

  @section('css')@endsection
  @section('js')@endsection