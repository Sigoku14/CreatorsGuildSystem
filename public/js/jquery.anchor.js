jQuery(function ($) {
    'use strict';
        /**
         * a要素に対する処理です。
         *     anchor.init()で実行してください。
         */
    var anchor = (function () {
                /**
                 * プライベート変数として使用する連想配列です。
                 * @type {Object}
                 */
            var _private = {
                    /**
                     * スクロールの移動速度です。
                     * @type {Number}
                     */
                    moveSpeed: 500,
                };
            return {
                /**
                 * 処理を実行します。
                 */
                init: function () {
                    this._setEvent();
                },
                /**
                 * イベントをセットします。
                 */
                _setEvent: function () {
                    /**
                     * 同ページ内のリンク実行をページ遷移ではなくスクロール移動にします。
                     */
                    $('a[href^="#"]').on('click', function (ev) {
                        var anchor = ev.currentTarget,
                            id = '',
                            target = '',
                            positionY = 0;
                        // onclick属性持ちは対象外
                        if (anchor.hasAttribute('onclick')) {
                            return;
                        }
                        // 移動先の取得
                        id = anchor.getAttribute('href').slice(1); // '#'以降の文字列
                        target = id ? document.getElementById(id) : document.body;
                        if (!target) {
                            return;
                        }
                        // 移動
                        positionY = target.offsetTop;
                        ev.preventDefault(); // 遷移処理の無効化
                        $('body, html').animate({scrollTop: positionY}, _private.moveSpeed);
                    });
                },
            };
        })(),
        /**
         * 指定要素(「トップに戻る」アイコン)の表示・非表示を切り替える処理です。
         */
        backToTop = (function () {
                /**
                 * プライベート変数として使用する連想配列です。
                 * @type {Object}
                 */
            var _private = {
                    /**
                     * アイコンを表示するブラウザ上部からの位置です。
                     * @type {Number}
                     */
                    viewPositionY: 160,
                    /**
                     * アイコンの表示・非表示速度です。
                     * @type {Number}
                     */
                    fadeSpeed: 200,
                    /**
                     * アイコンのIDです。
                     */
                    btnId: 'backToTop',
                };
            return {
                /**
                 * 処理を実行します。
                 */
                init: function () {
                    this._setEvent();
                },
                /**
                 * 表示・非表示イベントをセットします。
                 */
                _setEvent: function () {
                    var $window = $(window),
                        $btn = $('#' + _private.btnId);
                    $window.on('scroll', function (ev) {
                        // 位置によって要素の表示・非表示を切り替える
                        if ($window.scrollTop() > _private.viewPositionY) {
                            $btn.fadeIn(_private.fadeSpeed);
                        }
                        else {
                            $btn.fadeOut(_private.fadeSpeed);
                        }
                    });
                },
            };
        })(),
        /**
         * 関数を実行します。
         */
        run = (function () {
            anchor.init();
            backToTop.init();
        })();
});