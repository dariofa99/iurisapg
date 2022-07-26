@foreach($conciliacion->files as $key => $file)
                    <tr>
                        <td>
                            {{$file->pivot->concepto}}
                        </td>
                        <td>
                            <a href="/conciliaciones/download/file/{{$file->pivot->file_id}}" target="_blank">{{$file->original_name}}</a> 
                        </td>
                        <td>
                            {{$file->userinconciliacion[0]->name}} {{$file->userinconciliacion[0]->lastname}}
                        </td>
                        <td>
                            @if(($conciliacion->estado_id==174 || $conciliacion->estado_id==176 || $conciliacion->estado_id==194))
                           
                            @if(((currentUser()->hasRole('diradmin') || currentUser()->hasRole('coord_centro_conciliacion') || currentUser()->hasRole('amatai')))
                || (($file->pivot->user_id == auth()->user()->id)))
       
                            <button type="button" data-id="{{$file->pivot->file_id}}" class="btn btn-sm btn-primary btn_edit_anxcon" data-concept="{{$file->pivot->concepto}}">
                                Editar
                            </button>

                            <button type="button" data-id="{{$file->pivot->file_id}}" class="btn btn-sm btn-danger btn_delete_anxcon">
                                Eliminar
                            </button>  
                            
                          @endif  
                            @endif
                            


                        </td>
                    </tr>
                @endforeach