@extends('backend.layout')
@section('content')
<section class="content-header">
  <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Rates</h3>
      </div>
      <div class="box-body">
        <table class="table">
            <thead>
                    <th>Name Surname</th>
                    <th>Blog Title</th>
                    <th>Rating</th>
                    @if(Auth::user()->role==0)<th></th>
                    @endif
             </thead>   
                <tbody>
                  @foreach ($data['rate'] as $rate)
                    <tr class="table-active {{$rate->rate_status=="0" ? "bg-danger" : "bg-success"}}" id="item-{{$rate->id}}">
                    <td>{{$rate->name}}</td>
                    <td>{{$rate->blog_title}}</td>
                    <td>{{$rate->rate}}</td>
                    <td width="5"><a href="{{route('rate.show',$rate->id)}}"><i class="fa fa-info-circle fa-lg"></i></a></td>
                    @if(Auth::user()->role==0)
                    <td width="5">
                      <a href="javascript:void(0)"><i id="@php echo $rate->id @endphp" class="fa fa-trash-o fa-lg"></i></a></td>@endif
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

    $(".fa-trash-o").click(function () {
      
            destroy_id = $(this).attr('id');

            alertify.confirm('Silme işlemini onaylayın!', 'Bu işlem geri alınamaz',
                function () { 
                  $.ajax({
                    type:"DELETE",
                    url:"rate/"+destroy_id,
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
});
  </script>

@endsection

  @section('css')@endsection
  @section('js')@endsection