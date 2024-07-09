<div>
    <table>
        <thead>
            @if(isset($rows[1]))
            @foreach (array_slice($rows[1], 0, -2) as $key => $i)
            <!-- 마지막 두 요소를 제외 -->
            <th>
                {{$i}}
            </th>
            @endforeach
            @endif
        </thead>
        <tbody>
            @if(isset($rows[1]))
            @foreach (array_slice($rows, 1) as $i => $item)
            <tr>
                @foreach (array_slice($item, 0, -2) as $value)
                <!-- 각 행의 마지막 두 요소를 제외 -->
                <td>
                    {{$value}}
                </td>
                @endforeach
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
</div>