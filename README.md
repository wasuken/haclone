# haclone

hacker news clone 略してhaclone。

duskは現在よくわからんエラーで全然動かないのでファイルだけ残してる状態にしてる。

このままずっと使わないかもしれない。

# testing

composer testでテストが動きます。

以前、cacheが邪魔してテストがおかしな結果になることがあったため、

composer.jsonに登録されているtestスクリプトにはcacheを一通り削除する

処理が記載されているので気をつけてください。
