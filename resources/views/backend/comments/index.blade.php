@extends('backend.layout')
@section('content')
<section class="content-header">
  <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Comments</h3>
      </div>
      <div class="box-body">
        <table class="table">
            <thead>
                    <th>Name Surname</th>
                    <th>Blog Title</th>
                    <th>Comment Preview</th>
                    @if(Auth::user()->role==0)<th></th>
                    <th></th>@endif
             </thead>   
                <tbody id="sortable">
                  @foreach ($data['comment'] as $comment)
                    <tr class="table-active {{$comment->comment_status=="0" ? "bg-danger" : "bg-success"}}" id="item-{{$comment->id}}">
                    <td class="sortable">{{$comment->name}}</td>
                    <td class="sortable">{{$comment->blog_title}}</td>
                    <td class="sortable">{{substr($comment->comment_content,0,100)."..."}}</td>
                    <td width="5"><a href="{{route('comment.show',$comment->id)}}"><i class="fa fa-info-circle fa-lg"></i></a></td>
                    @if(Auth::user()->role==0)<td width="5"><a href="{{route('comment.edit',$comment->id)}}"><i class="fa fa-pencil-square fa-lg"></i></a></td>
                    <td width="5">
                      <a href="javascript:void(0)"><i id="@php echo $comment->id @endphp" class="fa fa-trash-o fa-lg"></i></a></td>@endif
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

        $('#sortable').sortable({
          revert: true,
          handle: ".sortable",
          stop: function(event, ui){
            var data = $(this).sortable('serialize');
            $.ajax({
              type:"POST",
              data: data,
              url: "{{route('comment.Sortable')}}",
              success: function(msg){
                if(msg){
                  alertify.success("İşlem Başarılı");
                } else {
                  alertify.error("İşlem Başarısız")
                }

              }
            });
          }

        });
        $('#sortable').disableSelection();

    });

    $(".fa-trash-o").click(function () {
      
            destroy_id = $(this).attr('id');

            alertify.confirm('Silme işlemini onaylayın!', 'Bu işlem geri alınamaz',
                function () { 
                  $.ajax({
                    type:"DELETE",
                    url:"comment/"+destroy_id,
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