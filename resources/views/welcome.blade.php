<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Form User</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>

<div class="container my-4">

  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <h5 class="mb-3">USER</h5>

  {{-- ==== FORM (partial) ==== --}}
  @include('form')

  {{-- Template baris keluarga untuk JS --}}
  <template id="familyRowTemplate">
    <tr>
      <td>
        <input type="text" name="__NAME__" class="form-control" placeholder="Masukan Nama">
      </td>
      <td>
        <input type="date" name="__DOB__" class="form-control">
      </td>
      <td class="text-end">
        <button type="button" class="btn btn-danger btn-sm remove-row">Hapus</button>
      </td>
    </tr>
  </template>

  {{-- ==== TABLE LIST CUSTOMER (partial) ==== --}}
  @include('table')

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const tableBody = document.querySelector('#familyTable tbody');
  const addBtn = document.getElementById('addFamilyRow');
  const tplHtml = document.getElementById('familyRowTemplate').innerHTML;

  if (!tableBody || !addBtn) return;
  let index = tableBody.querySelectorAll('tr').length;

  addBtn.addEventListener('click', function (e) {
    e.preventDefault();
    let rowHtml = tplHtml
      .replace('__NAME__', `families[${index}][name]`)
      .replace('__DOB__',  `families[${index}][dob]`);
    tableBody.insertAdjacentHTML('beforeend', rowHtml);
    index++;
  });

  tableBody.addEventListener('click', function (e) {
    if (e.target.classList.contains('remove-row')) {
      const rows = tableBody.querySelectorAll('tr');
      if (rows.length > 1) {
        e.target.closest('tr').remove();
      }
    }
  });
});
</script>

</body>
</html>