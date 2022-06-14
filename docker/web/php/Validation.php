<?php
require_once('ValidationUtil.php');

class Validation
{
    /**
     * アカウント新規登録時のバリデーションチェック
     * 
     * @param String $user_id ユーザーID
     * @param String $password パスワード
     * @param String $password_confirm パスワード確認
     * 
     * @return String $alert エラーメッセージ
     */
    public function userRegistValidation($user_id, $password, $password_confirm)
    {
        $alert = "";

        //未入力チェック
        if (empty($user_id) || empty($password) || empty($password_confirm)) {
            $alert = $alert . "未入力の項目があります。" . '\n';
        }

        //ユーザーIDの半角英数・文字数制限チェック
        if (!ValidationUtil::isHanEisu($user_id) || !ValidationUtil::isMaxLength($user_id, 20)) {
            $alert = $alert . "ユーザーIDは半角英数入力20文字以下でしてください。" . '\n';
        }

        //パスワードの半角英数・文字数制限チェック
        if (!ValidationUtil::isHanEisu($password) || !ValidationUtil::isMaxLength($password, 30)) {
            $alert = $alert . "パスワードは半角英数入力30文字以下でしてください。" . '\n';
        }

        //確認用パスワードの半角英数・文字数制限チェック
        if (!ValidationUtil::isHanEisu($password_confirm) || !ValidationUtil::isMaxLength($password_confirm, 30)) {
            $alert = $alert . "パスワード確認は半角英数入力30文字以下でしてください。" . '\n';
        }

        //パスワード確認チェック
        if ($password !== $password_confirm) {
            $alert = $alert . "パスワードが一致していません。";
        }

        //エラーが１つでもヒットしていたらエラー文表示
        if (!empty($alert)) {
            return $alert;
        }
    }

    /**
     * ログイン時のバリデーションチェック
     *
     * @param String $user_id
     * @param String $password
     *
     * @return String $login_alert エラーメッセージ
     */
    public function userLoginValidation($login_user_id, $login_password)
    {
        $login_alert = "";
        $login_valid = new UsersTable();
        $login_validation = $login_valid->getUserDataWhereUserId($login_user_id);

        //未入力チェック
        if (empty($login_user_id) || empty($login_password)) {
            $login_alert = $login_alert . "未入力の項目があります。" . '\n';
        }

        // ユーザがいない
        if (!$login_validation) {
            $login_alert = $login_alert . 'ユーザーIDが存在しません。';
        }

        if (password_verify($login_password, $login_validation['password'])) {
            //DBのユーザー情報をセッションに保存
            $_SESSION['loginUserId'] = $login_validation['user_id'];
        } else {
            $login_alert = $login_alert . 'ユーザーIDかパスワードが間違っています。';
        }

        //エラーが１つでもヒットしていたらエラー文表示
        if (!empty($login_alert)) {
            return $login_alert;
        }
    }
}