<div>
    Форма логина
    <form method="POST" action="/account/login">
        <table>
            <? if (!empty($data['error'])) {
            ?>
                <tr>
                    <td>
                    </td>
                    <td>
                    <?= $data['error']; ?>
                </td>
            </tr>
            <? } ?>
            <tr>
                <td>
                    E-mail:
                </td>
                <td>
                    <input type="text" name="email" value="<? print $data['post']['email']; ?>">
                </td>
            </tr>
            <tr>
                <td>
                    Пароль:
                </td>
                <td>
                    <input type="password" name="password">
                </td>
            </tr>
            <tr>
                <td>
                </td>
                <td>
                    <input type="submit" value="Вход">
                </td>
            </tr>
        </table>
    </form>
</div>