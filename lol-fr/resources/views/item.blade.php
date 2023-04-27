
@extends('layouts.app')

@section('content')
    <button type="button" style="
    background-color: #f5f5f5 ;
    border-radius:50% ;
    border-color:black;
    font-size:20px"
    class="btn " 
    data-bs-toggle="modal" 
    data-bs-target="#Modal">
    +
    </button>
    <table class="table">
    <thead>
    <tr>
        <th scope="col">Sil</th>
        <th scope="col">Düzenle</th>

        <th scope="col">ID</th>
        <th scope="col">Adı</th>
        <th scope="col">Açıklama</th>
        <th scope="col">Adet</th>
        <th scope="col">Oluşturma Tarihi</th>
        <th scope="col">Güncelleme Tarihi</th>
        </tr>
    </thead>
    <tbody>


    @foreach($yol as $item)
        
        <tr id="satir{{$item['id']}}" >
            <td>
                <button type="button " 
                    style=" background-color:#D49797;border-radius:50% ;
                    border-color:black;font-size:12px"
                    class="btn deleteItem" 
                    id='deleteItem'>
                    <i class="bi bi-trash"></i>
                </button>
            </td>
            <td>
                <a href="{{ route( 'item.edit', [ 'id' => $item['id'] ] ) }}" 
                    type="button" 
                    style=" background-color:grey ; border-radius:50% ;
                    border-color:black;font-size:12px"
                    class="btn"   >          
                    <i class="bi bi-pencil-square"></i>
                </a>
            </td>
            <td>{{$item['id']}}</td>
            <td>{{$item['name']}}</td>
            <td>{{$item['description']}}</td>
            <td>{{$item['quantity'] }}</td>
            <td>{{$item['created_at']}}</td>
            <td>{{$item['updated_at']}}</td>
        </tr>
        
    @endforeach

    </tbody>
    </table>


<div class="modal " id="Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Yeni Kategori Ekle</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

        <form id="frmItem" method="POST" action ="{{ route('item.store') }}">
            @csrf
          
    <div class="mb-3">
        <label for="name" class="form-label"> Adı</label>
        <input name="name" type="text" class="form-control" id="name" >
    </div>
    
    <div class="mb-3">
        <label for="description" class="form-label">Açıklama</label>
        <input name="description" type="text" class="form-control" id="description"  >

    </div>
    <div class="mb-3">
        <label for="quantity" class="form-label">Adet</label>
        <input name="quantity" type="number" class="form-control" id="quantity">

    </div>


    <button id="btnSave" type="submit" class="btn btn-primary">Kaydet</button>
    
    </form></div>

</div></div></div>

        
@endsection

@section('js')

<script>
  
$('#btnSave').click(function(){
  var name = $('#name').val();
  if(name.trim()=="")
  {
    
    Swal.fire
    ({
        icon:'error',
        title:'Hata!',
        text:'Kategori adı boş bırakılamaz!',
        confirmButtonText:'Tamam',
      })

     return false;
  }
  else
  {
    $('#frmItem').submit();
  }
  

});




$.ajaxSetup(
  {
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  }
);


const deleteButtons = document.querySelectorAll('#deleteItem');
deleteButtons.forEach(deleteButton => {
deleteButton.addEventListener('click', () => {
  const rowId = deleteButton.closest('tr').id.replace('satir', '');

  Swal.fire({
    title: 'Emin misiniz?',
    text: 'Bu öğeyi silmek istediğinize emin misiniz?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Evet, sil!',
    cancelButtonText: 'Hayır, iptal et'
  }).then((result) => {
    if (result.isConfirmed) {
      fetch(`http://127.0.0.1:8001/api/item/${rowId}`, {
        method: 'DELETE',
      })
      .then(response => {
        if (!response.ok) {
          throw new Error('hata');
        }
        console.log('silindi');
        Swal.fire(
          'Silindi!',
          'Öğe başarıyla silindi.',
          'success'
        ).then(() => {
          location.reload();
        });
      })
      .catch(error => {
        console.error('öğe silinirken bir hata oluştu', error);
        Swal.fire(
          'Hata!',
          'Öğeyi silerken bir hata oluştu.',
          'error'
        );
      });
    }
  });
});
});

</script>

@endsection



