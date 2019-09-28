<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// 以下を追記することでProfile Modelが扱えるようになる
use App\Profile;
use App\ProfileHistory;
use Carbon\Carbon;
use Auth;

class ProfileController extends Controller
{
    //関数を追加
    public function add()
    {
        return view('admin.profile.create');
    }
    public function create(Request $request)
    {
        // 以下を追記
        // Varidationを行う
        $this->validate($request, Profile::$rules);

        $profile = new Profile;
        $form = $request->all();

        // ログインユーザのIDを取得
        $form = $form + array('user_id' => Auth::id());

        // フォームから送信されてきた_tokenを削除する
        unset($form['_token']);

        // データベースに保存する
        $profile->fill($form);
        $profile->save();

        return redirect('admin/profile/create');
    }

    public function edit()
    {
        // Profile Modelからログインユーザのプロフィールを取得する
        $profile = Profile::where('user_id', Auth::id())->first();
        if (empty($profile)) {
          abort(404);
        }

        return view('admin.profile.edit', ['profile_form' => $profile]);
    }

    public function update(Request $request)
    {
        // Validationをかける
        $this->validate($request, Profile::$rules);
        // Profile Modelからデータを取得する
        $profile = Profile::where('user_id', $request->user_id)->first();
        // 送信されてきたフォームデータを格納する
        $profile_form = $request->all();

        unset($profile_form['_token']);

        \Debugbar::info($profile);
        \Debugbar::info($profile_form);

        // 該当するデータを上書きして保存する
        $profile->fill($profile_form)->save();

        // 編集履歴を更新
        $history = new ProfileHistory;
        $history->user_id = $profile->user_id;
        $history->edited_at = Carbon::now();
        $history->save();

        return redirect('admin/profile/edit');
    }
}
