<div class="">
	<h3>I miei articoli</h3>
	<div class="articles-list table-responsive">
        <table id="articles" class="table table-striped" cellspacing="0" width="100%">  
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Titolo</th>
                    <th>Slug</th>
                    <th>Status</th>
                    <th>Ultimo aggiornamento</th>
                    <th>Azioni</th>
                </tr>
            </thead>
            <tbody>

            @if (empty($articles))
                <tr class="text-center">
                    <td colspan="6">Non hai ancora alcun articolo.</td>
                </tr>
            @else
                @foreach ($articles as $article)                                       
                    <tr>
                        <td class="">
                            {{$article->id}}
                        </td>
                        <td class="">
                            {{$article->title}}
                        </td>
                        <td class="">
                            {{$article->slug}}
                        </td>
                        <td class="">
                            {{$article->active ? 'Pubblicato' : 'Non Pubblicato'}}
                        </td>
                        <td class="">
                            {{$article->updated_at}}
                        </td>
                        <td class="text-center buttons">
                            <a class="btn btn-sm btn-primary" href="{{ route('cms-backend.article.edit', [$article->id]) }}">Modifica</a>
                            @if (Auth::user()->is_admin())
                            	<a class="btn btn-sm btn-danger" href="{{ route('cms-backend.article.destroy', [$article->id]) }}">Elimina</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
	</div>
	<div class="pagination">
		{{ $articles->links() }}
	</div>
</div>
<!--datatables jquery plugin-->
<script>
    $(document).ready(function(){
        $('#articles').DataTable({
            "columnDefs": [{
                "targets": 'no-sort',
                "orderable": false,
            }],
            "paging": false,
            "info": false,
            "searching": false,
            "responsive": {
                "details": {
                    "display": $.fn.dataTable.Responsive.display.childRowImmediate,
                    "type": ''
                } 
            }
        });
    });
</script>