<div>
    Форма добавления вклада
    <div>
        <form method="POST" action="/holdings/add">
            <table>
                <tr>
                    <td>
                        Сумма вклада:
                    </td>
                    <td>
                        <input type="text" name="sum" value="<?= $data['post']['sum'] ?>">
                        <div>
                            <?
                            if (!empty($data['error']['sum'])) {
                                print $data['error']['sum'];
                            }
                            ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        Инвест-план:
                    </td>
                    <td>
                        <select name="plan">
                            <option value="0">не выбрано</option>
                            <option value="6" <?if($data['post']['plan'] == 6){ print 'selected'; } ?>>6m</option>
                            <option value="12" <?if($data['post']['plan'] == 12){ print 'selected'; }?>>12m</option>
                        </select>
                        <div>
                            <?
                            if (!empty($data['error']['plan'])) {
                                print $data['error']['plan'];
                            }
                            ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        Принимаю условия использования сервиса
                    </td>
                    <td>
                         <input type="checkbox" name="rule">
                          <div>
                            <?
                            if (!empty($data['error']['rule'])) {
                                print $data['error']['rule'];
                            }
                            ?>
                        </div>
                    </td>
                </tr>
              
                <tr>
                    <td>
                        <input type="button" onclick="location.href='/holdings'" value="Назад">
                    </td>
                    <td>
                        <input type="submit" value="Добавить вклад">
                        
                    </td>
                </tr>
            </table>
        </form>
    </div>

</div>