;
(function ($) {
    $.fn.countdownTimer = function (S) {
        var T = {
            date: "",
            timeZone: 0,
            past: false,
            dayTextNumber: 2,
            showDay: true,
            showHour: true,
            showMinute: true,
            showSecond: true,
            dayText: "Days",
            hourText: "Hours",
            minuteText: "Minutes",
            secondText: "Seconds",
            onFinish: function () {},
            imageFolder: "assets/img/countdown/"
        };
        var S = $.extend({}, T, S);
        var U = $(window);
        return this.each(function () {
            var a = $(this);
            a.addClass("countdown-timer");
            var b = new CountDownTimer($(this), S);
            b.init()
        });

        function CountDownTimer(o, p) {
            var q;
            var r = [],
                daysCurrent = [],
                daysUpBack = [],
                daysDownBack = [],
                daysUp = [],
                daysDown = [];
            var t = [],
                hoursCurrent = [],
                hoursUpBack = [],
                hoursDownBack = [],
                hoursUp = [],
                hoursDown = [];
            var u = [],
                minutesCurrent = [],
                minutesUpBack = [],
                minutesDownBack = [],
                minutesUp = [],
                minutesDown = [];
            var x = [],
                secondsCurrent = [],
                secondsUpBack = [],
                secondsDownBack = [],
                secondsUp = [],
                secondsDown = [];
            var z = "";
            var A, time, timeDiff;
            var B = false;
            var C = 0;
            var D = null;
            var E = 0,
                bgW = 0,
                marginLeft = 0,
                next = false;
            var F = $('<div class="bg" />');
            var G = $('<div class="back" />');
            var H = $('<div class="upperHalfBack" />');
            var I = $('<div class="lowerHalfBack" />');
            var J = $('<div class="front" />');
            var K = $('<div class="upperHalf" />');
            var L = $('<div class="lowerHalf" />');
            var M = $('<div class="sub-texts"><span class="day">' + p.dayText + '</span><span class="hour">' + p.hourText + '</span><span class="minute">' + p.minuteText + '</span><span class="second">' + p.secondText + '</span></div>');
            var N = parseInt(p.dayTextNumber) > 2 ? parseInt(p.dayTextNumber) : 2;
            var O = 2;
            var P = 2;
            var Q = 2;
            var R = typeof (p.onFinish) == "function" ? p.onFinish : function () {};
            this.init = function () {
                var a = this;
                q = o;
                this.convertToTime();
                q.append(F);
                q.append(M);
                q.append(G);
                H.html('<img src="' + p.imageFolder + 'spacer.png" />');
                I.html('<img src="' + p.imageFolder + 'spacer.png" />');
                G.append(H);
                G.append(I);
                q.append(J);
                K.html('<img src="' + p.imageFolder + 'spacer.png" />');
                L.html('<img src="' + p.imageFolder + 'spacer.png" />');
                J.append(K);
                J.append(L);
                $(window).resize(function () {
                    a.windowResized()
                });
                this.windowResized();
                this.addItem(p.showDay, N, "day", r, daysCurrent, daysUpBack, daysDownBack, daysUp, daysDown);
                this.addItem(p.showHour, O, "hour", t, hoursCurrent, hoursUpBack, hoursDownBack, hoursUp, hoursDown);
                this.addItem(p.showMinute, P, "minute", u, minutesCurrent, minutesUpBack, minutesDownBack, minutesUp, minutesDown);
                this.addItem(p.showSecond, Q, "second", x, secondsCurrent, secondsUpBack, secondsDownBack, secondsUp, secondsDown);
                q.onFinish = R;
                this.intervalId = setInterval(function () {
                    a.checkTime()
                }, 1000);
                a.checkTime()
            };
            this.convertToTime = function () {
                var a = p.date.split("/").join(" ").split(":").join(" ").split(" ");
                var y = parseInt(a[0], 10);
                var m = parseInt(a[1], 10) - 1;
                var d = parseInt(a[2], 10);
                var h = parseInt(a[3], 10);
                var i = parseInt(a[4], 10) - p.timeZone * 60;
                var s = parseInt(a[5], 10);
                p.date = new Date(y, m, d, h, i, s, 0).getTime()
            };
            this.windowResized = function () {
                var w = $(window).width();
                if (w >= 960) {
                    E = 46;
                    bgW = 86;
                    marginLeft = 23
                } else if (w >= 768 && w <= 959) {
                    E = 35;
                    bgW = 68;
                    marginLeft = 23
                } else if (w >= 480 && w <= 767) {
                    E = 29;
                    bgW = 54;
                    marginLeft = 9
                } else if (w >= 0 && w <= 479) {
                    E = 19;
                    bgW = 35;
                    marginLeft = 5
                }
                next = false;
                this.resizeText(p.showDay, N, "day");
                this.resizeText(p.showHour, O, "hour");
                this.resizeText(p.showMinute, P, "minute");
                this.resizeText(p.showSecond, Q, "second")
            };
            this.resizeText = function (a, b, c) {
                if (a) {
                    var d = M.find("." + c);
                    d.width(b * bgW);
                    if (next) {
                        d.css("margin-left", marginLeft + "px")
                    }
                    next = true
                }
            };
            this.addItem = function (a, b, c, d, e, f, g, h, j) {
                var k = M.find("." + c);
                for (i = 0; i < b; i++) {
                    d[i] = e[i] = -1;
                    if (a) {
                        if (i == 0 && z != "") {
                            F.append($('<img class="bg-dot" src="' + p.imageFolder + 'bg-dot.png" />'))
                        }
                        var l = i == 0 ? z : "";
                        f[i] = $('<img class="' + c + l + '" src="' + p.imageFolder + '0u.png" />');
                        H.append(f[i]);
                        g[i] = $('<img class="' + c + l + '" src="' + p.imageFolder + '0n.png" />');
                        I.append(g[i]);
                        h[i] = $('<img class="' + c + l + '" src="' + p.imageFolder + '0u.png" />');
                        K.append(h[i]);
                        j[i] = $('<img class="' + c + l + '" src="' + p.imageFolder + '0n.png" />');
                        L.append(j[i]);
                        $bgImg = $('<img src="' + p.imageFolder + 'bg-number.png" />');
                        F.append($bgImg);
                        z = " next"
                    }
                }
                if (!a) {
                    k.hide()
                }
            };
            this.checkTime = function () {
                time = new Date();
                A = time.getTime() + time.getTimezoneOffset() * 60 * 1000;
                timeDiff = !p.past ? p.date - A : A - p.date;
                if (timeDiff < 0) {
                    clearInterval(this.intervalId);
                    timeDiff = 0;
                    q.onFinish.call(this)
                }
                var a = this.timeFormat(timeDiff);
                var b = a.split("");
                var i = 0,
                    v = 0;
                for (i = 0; i < N; i++) {
                    r[i] = parseInt(b.shift())
                }
                var n = r.length - 1;
                if (p.showDay && r[n] != daysCurrent[n]) {
                    this.flip(r[n], daysUpBack[n], daysDownBack[n], daysUp[n], daysDown[n]);
                    daysCurrent[n] = r[n];
                    if (n > 0) {
                        for (i = 0; i < n; i++) {
                            if (daysCurrent[n] == 9 || !B) {
                                this.flip(r[i], daysUpBack[i], daysDownBack[i], daysUp[i], daysDown[i])
                            }
                        }
                    }
                }
                for (i = 0; i < O; i++) {
                    t[i] = parseInt(b.shift())
                }
                if (p.showHour && t[1] != hoursCurrent[1]) {
                    this.flip(t[1], hoursUpBack[1], hoursDownBack[1], hoursUp[1], hoursDown[1]);
                    hoursCurrent[1] = t[1];
                    if (hoursCurrent[1] == 9 || !B) {
                        this.flip(t[0], hoursUpBack[0], hoursDownBack[0], hoursUp[0], hoursDown[0])
                    }
                    if (hoursCurrent[0] < 1 && hoursCurrent[1] < 2) {
                        this.flip(t[0], hoursUpBack[0], hoursDownBack[0], hoursUp[0], hoursDown[0])
                    }
                    hoursCurrent[0] = t[0]
                }
                for (i = 0; i < P; i++) {
                    u[i] = parseInt(b.shift())
                }
                if (p.showMinute && u[1] != minutesCurrent[1]) {
                    this.flip(u[1], minutesUpBack[1], minutesDownBack[1], minutesUp[1], minutesDown[1]);
                    minutesCurrent[1] = u[1];
                    if (minutesCurrent[1] == 9 || !B) {
                        this.flip(u[0], minutesUpBack[0], minutesDownBack[0], minutesUp[0], minutesDown[0])
                    }
                    minutesCurrent[0] = u[0]
                }
                for (i = 0; i < Q; i++) {
                    x[i] = parseInt(b.shift())
                }
                if (p.showSecond && x[1] != secondsCurrent[1]) {
                    this.flip(x[1], secondsUpBack[1], secondsDownBack[1], secondsUp[1], secondsDown[1]);
                    secondsCurrent[1] = x[1];
                    if (secondsCurrent[1] == 9 || !B) {
                        this.flip(x[0], secondsUpBack[0], secondsDownBack[0], secondsUp[0], secondsDown[0])
                    }
                    secondsCurrent[0] = x[0];
                    B = true
                }
            };
            this.textFormat = function (a, b, c) {
                a = a.toString();
                while (a.length < b) {
                    a = c + a
                }
                if (a.length > b) {
                    a = a.substr(a.length - b, b)
                }
                return a
            };
            this.timeFormat = function (a) {
                var b = Math.floor(a / 1000);
                var s = b % 60;
                var i = Math.floor(b % (60 * 60) / 60);
                var h = Math.floor(b % (24 * 60 * 60) / (60 * 60));
                var d = Math.floor(b / (24 * 60 * 60));
                return this.textFormat(d, N, "0") + this.textFormat(h, O, "0") + this.textFormat(i, P, "0") + this.textFormat(s, Q, "0")
            };
            this.flip = function (a, b, c, d, e) {
                src = $(d).attr("src");
                ind = src.lastIndexOf("\/");
                path = src.substr(0, ind + 1);
                $(d).attr("src", $(b).attr("src")).height(E).css({
                    "visibility": "visible"
                });
                $(b).attr("src", path + a + "u.png");
                $(e).attr("src", path + a + "n.png").height("0px").css({
                    "visibility": "visible"
                });
                $(d).animate({
                    "height": 0
                }, {
                    "duration": 190,
                    defaultEasing: 'easeinout',
                    'complete': function () {
                        $(e).animate({
                            "height": E
                        }, {
                            "duration": 190,
                            defaultEasing: "easeinout",
                            "complete": function () {
                                $(c).attr("src", $(e).attr("src"));
                                $(d).height("0px").css({
                                    "visibility": "hidden"
                                });
                                $(e).height("0px").css({
                                    "visibility": "hidden"
                                })
                            }
                        })
                    }
                })
            };
            this.onFinish = function () {}
        }
    }
})(jQuery);