
        <div class="col-md-12">
            <div class="box-body table-responsive no-padding">
                <table class="normal-table table-list-est-tur">
                    <thead>
                        <th width="10%">
                            No. Documento
                        </th>
                        <th width="20%">
                            Estudiante
                        </th>
                        <th width="15%">
                            Curso
                        </th>
                        <th>
                            Horario
                        </th>
                        <th>
                            Conciliaciones
                        </th>
                        <th>
                            Rol
                        </th>
                        @if(currentUser()->hasRole('amatai') || currentUser()->hasRole('diradmin') || currentUser()->hasRole("dirgral"))
                        <th>
                            Acciones
                        </th>
                        @endif
                    </thead>
                    <tbody>
                        @foreach($turnos as $turno)
                        @if(isset($data_search) and $data_search!='')  {{-- mostrar busqueda --}}
                        @if($turno->cursando_id == $data_search)
                            <tr>
                            <td>
                            {{$turno->idnumber }}
                            </td>

                            <td align="left">
                                <input type="hidden" value="{{$turno->estudiante_id}}" id="estudiante_id{{$turno->id}}">
                                {{$turno->name }} {{$turno->lastname }}
                            </td>
                            <td>
                                <label> {{$turno->curso_nombre }} </label>
                            </td>
                            <td>
                                <label id="label_color{{$turno->id}}" class="label dis-block {{$turno->getColorTurno($turno->color_ref_value) }}">{{$turno->horario_nombre }}</label>
                            </td>
                            <td>
                                0
                            </td>
                            <td>
                            0
                            </td>

                            @if(currentUser()->hasRole('amatai') || currentUser()->hasRole('diradmin') || currentUser()->hasRole("dirgral"))
                            <td>
                                <a style="display: none;" class="btn btn-success btn_updatecolor" id="btnUpdatecolor_{{$turno->id}}"><i class="fa fa-check-square"> </i> Actualizar</a>

                                <a style="display: none;" class="btn btn-warning" id="btn_hideupdatecolor{{$turno->id}}" onclick="hideEditColor({{$turno->id}})"><i class="fa fa-close"> </i></a>

                                <a class="btn btn-primary" id="btn_habilityupdatecolor{{$turno->id}}" onclick="habilityEditColor({{$turno->id}})"><i class="fa fa-edit"> </i>Editar</a>

                                <a class="btn btn-danger btn_delete_turno" id="btn_delete_turno-{{$turno->id}}"><i class="fa fa-edit"> </i>Eliminar</a>

                            </td>
                            @endif
                        </tr>
                        @endif

                        @else
                        <tr>
                            <td>
                                {{$turno->idnumber }}
                            </td>

                            <td align="left">
                                <input type="hidden" value="{{$turno->estudiante_id}}" id="estudiante_id{{$turno->id}}">
                                {{$turno->name }} {{$turno->lastname }}
                            </td>
                            <td>
                            <label> {{$turno->curso_nombre}} </label>
                            </td>
                            <td>
                            <label class="label dis-block {{$turno->getColorTurno($turno->color_ref_value) }}">{{$turno->horario_nombre }}</label>
                            </td>
                            <td>
                                <label id="label_num_conciliacion_est{{$turno->idnumber}}" style="font-weight: 100;"> 0 </label>
                            </td>
                            <td>
                                <label id="label_rol_est_conciliacion{{$turno->idnumber}}" style="font-weight: 100; font-size: 13px;"> sin asignar </label>
                                <select class="form-control input-select" name="select" id="select_rol_est_conciliacion{{$turno->idnumber}}" data-id="{{$conciliacion->id}}" style="display: none;">
                                    <option value="000">Eliminar asignación</option>

                                </select>
                            </td>
                            @if(currentUser()->hasRole('amatai') || currentUser()->hasRole('diradmin') || currentUser()->hasRole("dirgral"))
                            <td>
                                <a style="display: none;" class="btn btn-success" id="btn_UpdateRol_est{{$turno->idnumber}}" onclick="Updaterolest_conciliacion('{{$turno->idnumber}}')"><i class="fa fa-check-square"> </i> Actualizar</a>
                                <a style="display: none;" class="btn btn-warning" id="btn_hide_edit_rol_conciliacion_est{{$turno->idnumber}}" onclick="hideupdaterolest('{{$turno->idnumber}}')"><i class="fa fa-close"> </i> Cancelar</a>
                                <a class="btn btn-primary" id="btn_habilityEditRol_Est{{$turno->idnumber}}" data-state="" onclick="editRolEstudentAudiencia('{{$turno->idnumber}}')"><i class="fa fa-edit"> </i>Editar</a>
                            </td>
                            @endif
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>

            <hr>
        </div>
