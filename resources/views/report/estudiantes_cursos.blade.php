   <table>
       <tbody>
            <tr>
                <td>
                    No
                </td>
                <td>
                    No. Documento
                </td>
                <td>
                    Estudiante
                </td>
                <td>
                    Color
                </td>
                <td>
                    Curso			
                </td>
                <td>
                    Horario
                </td>
                <td>
                    Oficina
                </td>
                <td>
                    Dia
                </td>
            </tr>
            @foreach ($users as $key => $user)
                <tr>
                    <td>
                        {{$key+1}}
                    </td>
                    <td>
                        {{$user->idnumber}}
                    </td>
                    <td>
                        {{$user->name}} {{$user->lastname}}
                    </td>
                    <td>
                        {{$user->color_nombre}}
                    </td>
                    <td>
                        {{$user->curso_nombre}}
                    </td>
                    <td>
                        {{$user->horario_nombre}}
                    </td>
                    <td>
                        {{$user->oficina_nombre}}
                    </td>
                    <td>
                        {{$user->dia_nombre}}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
