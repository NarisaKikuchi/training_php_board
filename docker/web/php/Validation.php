<?php
require_once('ValidationUtil.php');

class Validation
{

    public function userRegistValidation($userid, $password, $passwordconfirm)
    {
        $alert = "";

        //未入力チェック
        if (empty($userid && $password && $passwordconfirm)) {
            $alert = $alert . "未入力の項目があります。" . '\n';
        }

        //ユーザーIDの半角英数・文字数制限チェック
        if (!ValidationUtil::isHanEisu($userid) || !ValidationUtil::isMaxLength($userid, 20)) {
            $alert = $alert . "ユーザーIDは半角英数入力20文字以下でしてください。" . '\n';
        }

        //パスワードの半角英数・文字数制限チェック
        if (!ValidationUtil::isHanEisu($password) || !ValidationUtil::isMaxLength($password, 30)) {
            $alert = $alert . "パスワードは半角英数入力30文字以下でしてください。" . '\n';
        }

        //確認用パスワードの半角英数・文字数制限チェック
        if (!ValidationUtil::isHanEisu($passwordconfirm) || !ValidationUtil::isMaxLength($passwordconfirm, 30)) {
            $alert = $alert . "パスワード確認は半角英数入力30文字以下でしてください。" . '\n';
        }

        //パスワード確認チェック
        if ($password != $passwordconfirm) {
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
     * @param String $userid
     * @param String $password
     *
     * @return String $loginalert エラーメッセージ
     */
    public function userLoginValidation($loginuserid, $loginpassword)
    {
        $loginalert = "";
        $loginvalid = new usersTable();
        $loginvalidation = $loginvalid->userLogin($loginuserid);

        //未入力チェック
        if (empty($loginuserid && $loginpassword)) {
            $loginalert = $loginalert . "未入力の項目があります。" . '\n';
        }

        // ユーザがいない
        if (!$loginvalidation) {
            $loginalert = $loginalert . 'ユーザーIDが存在しません。';
        }

        if (password_verify($loginpassword, $loginvalidation['password'])) {
            //DBのユーザー情報をセッションに保存
            $_SESSION['loginuserid'] = $loginvalidation['user_id'];
        } else {
            $loginalert = $loginalert . 'ユーザーIDかパスワードが間違っています。';
        }

        //エラーが１つでもヒットしていたらエラー文表示
        if (!empty($loginalert)) {
            return $loginalert;
        }
    }
}