@extends('layouts.admin')
@section('content')
<script src="{{ asset('js/jquery.js') }}"></script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header"> Translations </div>
                <div class="card-body text-center">
                    <form action='/language/translation' method="POST">
                        @method('post')
                        @csrf
                        <table id="translation_table" width="100%" data-languages="<?= implode(',', array_column($languages, 'code')) ?>">
                            <thead>
                                <tr>
                                    <th> Keys </th>
                                    @foreach($languages as $language)
                                        <th>{{ $language['name'] }}</th>
                                    @endforeach
                                    <th> <!-- empty --> </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($po_strings as $key => $po_array)
                                    <tr>
                                        <td> {{ $key }} </td>
                                        @foreach($languages as $language)
                                            <td><input type="text" name="key[{{ $language['code'] }}][{{ $key }}]" value="{{ $po_array[strtolower($language['code'])] ?? "" }}"></td>
                                        @endforeach
                                        <td><a href="javascript:void(0)" class="delete-link" onclick="$(this).parent().parent().remove()" class="d-block">&times;</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <br>
                        <input type="submit" value="save">
                    </form>
                    <br>
                    <input type="text" id="new_trans_key" placeholder="New key" value="">
                    <button id="addTranslationButton">Add</button>
                    <br>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    var table = $('#translation_table');
    var tbody = table.find('tbody');
    var lang = table.data('languages').toLowerCase().split(',');
    var input = $('#new_trans_key');
    $('#addTranslationButton').click(function(){
        newTranslation();
    });
    function newTranslation(){
        var key = input.val();
        var cell = [];
        if (!key.trim().length || !/^[a-zA-Z0-9_]*$/.test(key)) {
            return alert('Wrong translation key, please use alphanumeric characters');
        }
        $('#myTable > tbody:last-child').append('<tr>...</tr><tr>...</tr>');
        console.log(/^[a-zA-Z0-9_]*$/.test(key));
        console.log(lang);
        console.log(key);
        cell.push(key);
        lang.forEach(function(lang){
            cell.push('<input type="text" name="key['+lang+']['+key+']" value="">')
        });
        cell.push('<a href="javascript:void(0)" class="delete-link" onclick="$(this).parent().parent().remove()" class="d-block">&times;</a>');
        tbody.append("<tr><td>"+cell.join('</td><td>')+"</td></tr>");
        input.val('');
    }
});
</script>
@endsection
