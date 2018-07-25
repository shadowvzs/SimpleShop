<h2>Uzenet - {{ date('Y/m/d H:i:s') }}</h2>
<table style="width: 100%;max-width: 500px;">
  <tr>
      <td> {{ trans('default.client_name') }}: </td> <td> {{ $client['name'] }} </td>
  </tr>
  <tr>
      <td> {{ trans('default.client_phone') }}: </td> <td> {{ $client['phone'] }} </td>
  </tr>
  <tr>
      <td> {{ trans('default.client_email') }}: </td> <td> {{ $client['email'] }} </td>
  </tr>
  <tr>
      <td> {{ trans('default.client_note') }}: </td> <td> {{ $client['comment'] }} </td>
  </tr>
</table>
