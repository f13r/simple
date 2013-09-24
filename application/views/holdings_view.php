<div>


    <? if(!empty($data)) { ?>
    <table>
        <tr>
            <td>
                ID
            </td>
            <td>
                Дата вклада
            </td>
            <td>
                Инвест-план
            </td>
            <td>
                Сумма
            </td>
            <td>
                Дата окончания договора
            </td>
            <td>
                Начислено на сегодняшний день
            </td>
            <td>
                Квитанция оплаты
            </td>
            <td>
                Статус
            </td>
        </tr>
    <? foreach($data as $row){ ?>
    <tr>
        <td><?if(!empty($row['id'])) { print $row['id']; } else { print '-'; } ?></td>
        <td><?if(!empty($row['created_at'])) { print $row['created_at']; } else { print '-'; } ?></td>
        <td><?if(!empty($row['plan'])) { print $row['plan'].' m'; } else { print '-'; } ?></td>
        <td><?if(!empty($row['sum'])) { print $row['sum'].' грн'; } else { print '-'; } ?></td>
        <td><?if(!empty($row['date_end_contract'])) { print $row['date_end_contract']; } else { print '-'; } ?></td>
        <td><?if(!empty($row['now'])) { print $row['now']; } else { print '-'; } ?></td>
        <td><?if(!empty($row['order'])) { print $row['order']; } else { print '-'; } ?></td>
        <td><?if(!empty($row['status'])) { if($row['status'] == 1)  { print 'Подтвержденно'; } else { print 'Отклонено';} }
         else { print 'Ожидание подтверждения'; }?></td>
        }

    </tr>
    <? } ?>

    </table>
    <? } else { ?>
    У Вас ещё нет вкладов

    <? } ?>
    <br>

    <input type="button" onclick="location.href='/holdings/add'" value="Добавить новый вклад">
</div>

