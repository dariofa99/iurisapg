@foreach($conciliacion->files as $key => $file)
                    <tr>
                        <td>
                            {{$file->pivot->concepto}}
                        </td>
                        <td>
                            <a href="/conciliaciones/download/file/{{$file->pivot->file_id}}" target="_blank">{{$file->original_name}}</a> 
                        </td>
                        <td>
                            @if(($conciliacion->estado_id!=177 and $conciliacion->estado_id!=179)  and !auth()->user()->can('act_conciliacion'))
                            @else 
                            <button type="button" data-id="{{$file->pivot->file_id}}" class="btn btn-sm btn-primary btn_edit_anxcon" data-concept="{{$file->pivot->concepto}}">
                                Editar
                            </button>

                            <button type="button" data-id="{{$file->pivot->file_id}}" class="btn btn-sm btn-danger btn_delete_anxcon">
                                Eliminar
                            </button>  @endif
                            


                        </td>
                    </tr>
                @endforeach