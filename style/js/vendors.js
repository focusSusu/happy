/******/ (function(modules) { // webpackBootstrap
    /******/ 	// install a JSONP callback for chunk loading
    /******/ 	var parentJsonpFunction = window["webpackJsonp"];
    /******/ 	window["webpackJsonp"] = function webpackJsonpCallback(chunkIds, moreModules) {
        /******/ 		// add "moreModules" to the modules object,
        /******/ 		// then flag all "chunkIds" as loaded and fire callback
        /******/ 		var moduleId, chunkId, i = 0, callbacks = [];
        /******/ 		for(;i < chunkIds.length; i++) {
            /******/ 			chunkId = chunkIds[i];
            /******/ 			if(installedChunks[chunkId])
            /******/ 				callbacks.push.apply(callbacks, installedChunks[chunkId]);
            /******/ 			installedChunks[chunkId] = 0;
            /******/ 		}
        /******/ 		for(moduleId in moreModules) {
            /******/ 			modules[moduleId] = moreModules[moduleId];
            /******/ 		}
        /******/ 		if(parentJsonpFunction) parentJsonpFunction(chunkIds, moreModules);
        /******/ 		while(callbacks.length)
            /******/ 			callbacks.shift().call(null, __webpack_require__);
        /******/ 		if(moreModules[0]) {
            /******/ 			installedModules[0] = 0;
            /******/ 			return __webpack_require__(0);
            /******/ 		}
        /******/ 	};

    /******/ 	// The module cache
    /******/ 	var installedModules = {};

    /******/ 	// object to store loaded and loading chunks
    /******/ 	// "0" means "already loaded"
    /******/ 	// Array means "loading", array contains callbacks
    /******/ 	var installedChunks = {
        /******/ 		3:0
        /******/ 	};

    /******/ 	// The require function
    /******/ 	function __webpack_require__(moduleId) {

        /******/ 		// Check if module is in cache
        /******/ 		if(installedModules[moduleId])
        /******/ 			return installedModules[moduleId].exports;

        /******/ 		// Create a new module (and put it into the cache)
        /******/ 		var module = installedModules[moduleId] = {
            /******/ 			exports: {},
            /******/ 			id: moduleId,
            /******/ 			loaded: false
            /******/ 		};

        /******/ 		// Execute the module function
        /******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);

        /******/ 		// Flag the module as loaded
        /******/ 		module.loaded = true;

        /******/ 		// Return the exports of the module
        /******/ 		return module.exports;
        /******/ 	}

    /******/ 	// This file contains only the entry chunk.
    /******/ 	// The chunk loading function for additional chunks
    /******/ 	__webpack_require__.e = function requireEnsure(chunkId, callback) {
        /******/ 		// "0" is the signal for "already loaded"
        /******/ 		if(installedChunks[chunkId] === 0)
        /******/ 			return callback.call(null, __webpack_require__);

        /******/ 		// an array means "currently loading".
        /******/ 		if(installedChunks[chunkId] !== undefined) {
            /******/ 			installedChunks[chunkId].push(callback);
            /******/ 		} else {
            /******/ 			// start chunk loading
            /******/ 			installedChunks[chunkId] = [callback];
            /******/ 			var head = document.getElementsByTagName('head')[0];
            /******/ 			var script = document.createElement('script');
            /******/ 			script.type = 'text/javascript';
            /******/ 			script.charset = 'utf-8';
            /******/ 			script.async = true;

            /******/ 			script.src = __webpack_require__.p + "" + chunkId + "." + ({"0":"addCourse","1":"land","2":"login"}[chunkId]||chunkId) + ".js";
            /******/ 			head.appendChild(script);
            /******/ 		}
        /******/ 	};

    /******/ 	// expose the modules object (__webpack_modules__)
    /******/ 	__webpack_require__.m = modules;

    /******/ 	// expose the module cache
    /******/ 	__webpack_require__.c = installedModules;

    /******/ 	// __webpack_public_path__
    /******/ 	__webpack_require__.p = "";

    /******/ 	// Load entry module and return exports
    /******/ 	return __webpack_require__(0);
    /******/ })
/************************************************************************/
/******/ ([
    /* 0 */
    /***/ function(module, exports, __webpack_require__) {

        __webpack_require__(11);
        __webpack_require__(23);
        __webpack_require__(10);
        module.exports = __webpack_require__(7);


        /***/ },
    /* 1 */,
    /* 2 */,
    /* 3 */,
    /* 4 */,
    /* 5 */,
    /* 6 */,
    /* 7 */
    /***/ function(module, exports) {

        var getdata = "../../yili_admin/"; //鏈嶅姟鍣ㄦ帴鍙�
        // var getdata = "../../getdata/";//鏈湴鎺ュ彛

        module.exports = {
            "upload": getdata + "course/uploadFile", //涓婁紶
            "getCategory": getdata + "course/getCategory", //鍒嗙被
            "getExpert": getdata + "course/getExpert", //鑾峰彇涓撳
            "addCourse": getdata + "course/addCourse", //娣诲姞璇剧▼
            "updateCourse": getdata + "course/updateCourse", //鏇存柊璇剧▼
            "getDataById": getdata + "course/getDataById" };

        /***/ },
    /* 8 */
    /***/ function(module, exports, __webpack_require__) {

        var template = __webpack_require__(9);

        template.config('escape', false);

        //鏃ユ湡鏍煎紡
        /**
         * 瀵规棩鏈熻繘琛屾牸寮忓寲锛�
         * @param date 瑕佹牸寮忓寲鐨勬棩鏈�
         * @param format 杩涜鏍煎紡鍖栫殑妯″紡瀛楃涓�
         *     鏀寔鐨勬ā寮忓瓧姣嶆湁锛�
         *     y:骞�,
         *     M:骞翠腑鐨勬湀浠�(1-12),
         *     d:鏈堜唤涓殑澶�(1-31),
         *     h:灏忔椂(0-23),
         *     m:鍒�(0-59),
         *     s:绉�(0-59),
         *     S:姣(0-999),
         *     q:瀛ｅ害(1-4)
         * @return String
         */
        template.helper('xx', function (date, format) {

            date = new Date(date);
            var map = {
                "M": date.getMonth() + 1, //鏈堜唤
                "d": date.getDate(), //鏃�
                "h": date.getHours(), //灏忔椂
                "m": date.getMinutes(), //鍒�
                "s": date.getSeconds(), //绉�
                "q": Math.floor((date.getMonth() + 3) / 3), //瀛ｅ害
                "S": date.getMilliseconds() //姣
            };

            format = format.replace(/([yMdhmsqS])+/g, function (all, t) {
                var v = map[t];
                if (v !== undefined) {
                    if (all.length > 1) {
                        v = '0' + v;
                        v = v.substr(v.length - 2);
                    }
                    return v;
                } else if (t === 'y') {
                    return (date.getFullYear() + '').substr(4 - all.length);
                }
                return all;
            });
            return format;
        });

        module.exports = template;

        /***/ },
    /* 9 */
    /***/ function(module, exports, __webpack_require__) {

        var __WEBPACK_AMD_DEFINE_RESULT__;/*!art-template - Template Engine | http://aui.github.com/artTemplate/*/
        !function () {
            function a(a) {
                return a.replace(t, "").replace(u, ",").replace(v, "").replace(w, "").replace(x, "").split(y);
            }function b(a) {
                return "'" + a.replace(/('|\\)/g, "\\$1").replace(/\r/g, "\\r").replace(/\n/g, "\\n") + "'";
            }function c(c, d) {
                function e(a) {
                    return m += a.split(/\n/).length - 1, k && (a = a.replace(/\s+/g, " ").replace(/<!--[\w\W]*?-->/g, "")), a && (a = s[1] + b(a) + s[2] + "\n"), a;
                }function f(b) {
                    var c = m;if (j ? b = j(b, d) : g && (b = b.replace(/\n/g, function () {
                        return m++, "$line=" + m + ";";
                    })), 0 === b.indexOf("=")) {
                        var e = l && !/^=[=#]/.test(b);if (b = b.replace(/^=[=#]?|[\s;]*$/g, ""), e) {
                            var f = b.replace(/\s*\([^\)]+\)/, "");n[f] || /^(include|print)$/.test(f) || (b = "$escape(" + b + ")");
                        } else b = "$string(" + b + ")";b = s[1] + b + s[2];
                    }return g && (b = "$line=" + c + ";" + b), r(a(b), function (a) {
                        if (a && !p[a]) {
                            var b;b = "print" === a ? u : "include" === a ? v : n[a] ? "$utils." + a : o[a] ? "$helpers." + a : "$data." + a, w += a + "=" + b + ",", p[a] = !0;
                        }
                    }), b + "\n";
                }var g = d.debug,
                    h = d.openTag,
                    i = d.closeTag,
                    j = d.parser,
                    k = d.compress,
                    l = d.escape,
                    m = 1,
                    p = { $data: 1, $filename: 1, $utils: 1, $helpers: 1, $out: 1, $line: 1 },
                    q = "".trim,
                    s = q ? ["$out='';", "$out+=", ";", "$out"] : ["$out=[];", "$out.push(", ");", "$out.join('')"],
                    t = q ? "$out+=text;return $out;" : "$out.push(text);",
                    u = "function(){var text=''.concat.apply('',arguments);" + t + "}",
                    v = "function(filename,data){data=data||$data;var text=$utils.$include(filename,data,$filename);" + t + "}",
                    w = "'use strict';var $utils=this,$helpers=$utils.$helpers," + (g ? "$line=0," : ""),
                    x = s[0],
                    y = "return new String(" + s[3] + ");";r(c.split(h), function (a) {
                    a = a.split(i);var b = a[0],
                        c = a[1];1 === a.length ? x += e(b) : (x += f(b), c && (x += e(c)));
                });var z = w + x + y;g && (z = "try{" + z + "}catch(e){throw {filename:$filename,name:'Render Error',message:e.message,line:$line,source:" + b(c) + ".split(/\\n/)[$line-1].replace(/^\\s+/,'')};}");try {
                    var A = new Function("$data", "$filename", z);return A.prototype = n, A;
                } catch (B) {
                    throw B.temp = "function anonymous($data,$filename) {" + z + "}", B;
                }
            }var d = function (a, b) {
                return "string" == typeof b ? q(b, { filename: a }) : g(a, b);
            };d.version = "3.0.0", d.config = function (a, b) {
                e[a] = b;
            };var e = d.defaults = { openTag: "<%", closeTag: "%>", escape: !0, cache: !0, compress: !1, parser: null },
                f = d.cache = {};d.render = function (a, b) {
                return q(a, b);
            };var g = d.renderFile = function (a, b) {
                var c = d.get(a) || p({ filename: a, name: "Render Error", message: "Template not found" });return b ? c(b) : c;
            };d.get = function (a) {
                var b;if (f[a]) b = f[a];else if ("object" == typeof document) {
                    var c = document.getElementById(a);if (c) {
                        var d = (c.value || c.innerHTML).replace(/^\s*|\s*$/g, "");b = q(d, { filename: a });
                    }
                }return b;
            };var h = function (a, b) {
                    return "string" != typeof a && (b = typeof a, "number" === b ? a += "" : a = "function" === b ? h(a.call(a)) : ""), a;
                },
                i = { "<": "&#60;", ">": "&#62;", '"': "&#34;", "'": "&#39;", "&": "&#38;" },
                j = function (a) {
                    return i[a];
                },
                k = function (a) {
                    return h(a).replace(/&(?![\w#]+;)|[<>"']/g, j);
                },
                l = Array.isArray || function (a) {
                    return "[object Array]" === {}.toString.call(a);
                },
                m = function (a, b) {
                    var c, d;if (l(a)) for (c = 0, d = a.length; d > c; c++) b.call(a, a[c], c, a);else for (c in a) b.call(a, a[c], c);
                },
                n = d.utils = { $helpers: {}, $include: g, $string: h, $escape: k, $each: m };d.helper = function (a, b) {
                o[a] = b;
            };var o = d.helpers = n.$helpers;d.onerror = function (a) {
                var b = "Template Error\n\n";for (var c in a) b += "<" + c + ">\n" + a[c] + "\n\n";"object" == typeof console && console.error(b);
            };var p = function (a) {
                    return d.onerror(a), function () {
                        return "{Template Error}";
                    };
                },
                q = d.compile = function (a, b) {
                    function d(c) {
                        try {
                            return new i(c, h) + "";
                        } catch (d) {
                            return b.debug ? p(d)() : (b.debug = !0, q(a, b)(c));
                        }
                    }b = b || {};for (var g in e) void 0 === b[g] && (b[g] = e[g]);var h = b.filename;try {
                        var i = c(a, b);
                    } catch (j) {
                        return j.filename = h || "anonymous", j.name = "Syntax Error", p(j);
                    }return d.prototype = i.prototype, d.toString = function () {
                        return i.toString();
                    }, h && b.cache && (f[h] = d), d;
                },
                r = n.$each,
                s = "break,case,catch,continue,debugger,default,delete,do,else,false,finally,for,function,if,in,instanceof,new,null,return,switch,this,throw,true,try,typeof,var,void,while,with,abstract,boolean,byte,char,class,const,double,enum,export,extends,final,float,goto,implements,import,int,interface,long,native,package,private,protected,public,short,static,super,synchronized,throws,transient,volatile,arguments,let,yield,undefined",
                t = /\/\*[\w\W]*?\*\/|\/\/[^\n]*\n|\/\/[^\n]*$|"(?:[^"\\]|\\[\w\W])*"|'(?:[^'\\]|\\[\w\W])*'|\s*\.\s*[$\w\.]+/g,
                u = /[^\w$]+/g,
                v = new RegExp(["\\b" + s.replace(/,/g, "\\b|\\b") + "\\b"].join("|"), "g"),
                w = /^\d[^,]*|,\d[^,]*/g,
                x = /^,+|,+$/g,
                y = /^$|,+/;e.openTag = "{{", e.closeTag = "}}";var z = function (a, b) {
                var c = b.split(":"),
                    d = c.shift(),
                    e = c.join(":") || "";return e && (e = ", " + e), "$helpers." + d + "(" + a + e + ")";
            };e.parser = function (a) {
                a = a.replace(/^\s/, "");var b = a.split(" "),
                    c = b.shift(),
                    e = b.join(" ");switch (c) {case "if":
                    a = "if(" + e + "){";break;case "else":
                    b = "if" === b.shift() ? " if(" + b.join(" ") + ")" : "", a = "}else" + b + "{";break;case "/if":
                    a = "}";break;case "each":
                    var f = b[0] || "$data",
                        g = b[1] || "as",
                        h = b[2] || "$value",
                        i = b[3] || "$index",
                        j = h + "," + i;"as" !== g && (f = "[]"), a = "$each(" + f + ",function(" + j + "){";break;case "/each":
                    a = "});";break;case "echo":
                    a = "print(" + e + ");";break;case "print":case "include":
                    a = c + "(" + b.join(",") + ");";break;default:
                    if (/^\s*\|\s*[\w\$]/.test(e)) {
                        var k = !0;0 === a.indexOf("#") && (a = a.substr(1), k = !1);for (var l = 0, m = a.split("|"), n = m.length, o = m[l++]; n > l; l++) o = z(o, m[l]);a = (k ? "=" : "=#") + o;
                    } else a = d.helpers[c] ? "=#" + c + "(" + b.join(",") + ");" : "=" + a;}return a;
            },  true ? !(__WEBPACK_AMD_DEFINE_RESULT__ = function () {
                return d;
            }.call(exports, __webpack_require__, exports, module), __WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__)) : "undefined" != typeof exports ? module.exports = d : this.template = d;
        }();

        /***/ },
    /* 10 */
    /***/ function(module, exports, __webpack_require__) {

        var url = __webpack_require__(7);
        var template = __webpack_require__(9);
        var main = __webpack_require__(11);
        var modalTpl = __webpack_require__(19);

        //妯℃澘閰嶇疆
        var tplArr = [];
        template.config('escape', false);
        tplArr['modal'] = template.compile(modalTpl.replace(/^\s*|\s*$/g, ""));

        //寮圭獥
        function jsAlert(text, Fun) {
            if (!Fun) {
                Fun = 'm-click="modalAlertClose"';
            }
            var data = {
                "type": "1",
                "ico": 'warn',
                "text": text,
                "Callback": Fun
            };
            $('body').append(tplArr['modal'](data));
        }

        //琛ㄥ崟鏁版嵁鏁寸悊
        function ajaxSubmit(obj, module, but, doSubmit) {
            //console.info(module)
            var but_val = but.html();
            if (but_val == "鎻愪氦涓�...") {
                console.info("棰戞澶揩");
                return false;
            }
            //var url = $(obj).attr("action") || window.location.href;
            var callback_name = $(obj).attr("callback");
            var url = $(obj).attr("action");
            var formtype = $(obj).attr("f-type");
            var data = {};
            $('input[name],textarea[name],select[name]', obj).each(function (index, item) {

                var name = $(this).attr('name');
                // var value = $(this).val();
                var ipt = $(this).attr('ipt');
                var checked = $(this).prop('checked');
                var type = $(this).attr("type");
                if (type == "radio") {
                    var value = $('input[name=' + name + ']:checked').val();
                } else {
                    var value = $(this).val();
                }
                if (name in data) {
                    if (type == 'radio') {
                        data[name] = value;
                    } else {
                        if (data[name] instanceof Array) {
                            data[name].push(value);
                        } else {
                            data[name] = [data[name]];
                            data[name].push(value);
                        }
                    }
                } else {
                    data[name] = value;
                }
            });
            //alert(url+JSON.stringify(data))
            if (!yzForm(data)) {
                return false;
            }
            but.attr('isSubmit', 'false').html('鎻愪氦涓�...');
            if (doSubmit) {
                $("form").submit();
            } else {
                main.post(url, data, function (ret) {
                    if (ret.code == 200) {
                        module[callback_name](ret);
                        but.html(but_val);
                    } else {
                        but.html(but_val);
                        alert(ret.msg);
                    }
                });
            }
        }
        //鏂规硶楠岃瘉
        function yzForm(data) {
            var Ctrue = true;
            var hour = $('select[name="sendplan_hour"]').val();
            console.log(data, 'shuju ');
            for (ipt in data) {
                switch (ipt) {
                    case 'name':
                        if (!data[ipt]) {
                            isCtrue('璇疯緭鍏ヨ绋嬪悕绉�');return false;
                        }
                        break;
                    case 'type':
                        if (!data[ipt]) {
                            isCtrue('璇烽€夋嫨璇剧▼灞炴€�');return false;
                        }
                        break;
                    case 'is_top':
                        if (!data[ipt]) {
                            isCtrue('璇烽€夋嫨鏄惁缃《');return false;
                        }
                        break;
                    case 'is_recommend':
                        if (!data[ipt]) {
                            isCtrue('璇烽€夋嫨鏄惁浠婃棩鎺ㄨ崘');return false;
                        }
                        break;
                    case 'recommend_time':
                        if (!data[ipt]) {
                            isCtrue('璇烽€夋嫨鎺ㄨ崘鏃堕棿');return false;
                        }
                        break;
                    case 'valid_time':
                        if (!data[ipt]) {
                            isCtrue('璇烽€夋嫨涓婃灦鏃堕棿');return false;
                        }
                        break;
                    case 'is_vip':
                        if (!data[ipt]) {
                            isCtrue('璇烽€夋嫨鏄惁浼氬憳闄愬埗');return false;
                        }
                        break;
                    case 'category_id':
                        if (data[ipt] instanceof Array) {
                            for (i in data[ipt]) {
                                if (data[ipt][i] == "") {
                                    isCtrue('璇烽€夋嫨鏍囩');return false;
                                }
                                break;
                            }
                        } else {
                            if (!data[ipt]) {
                                isCtrue('璇烽€夋嫨鏍囩');return false;
                            } else {
                                data[ipt] = [data[ipt]];
                            }
                            break;
                        }
                    case 'expert_id':
                        if (!data[ipt]) {
                            isCtrue('璇烽€夋嫨鎵€灞炰笓瀹�');return false;
                        }
                        break;
                    case 'cover_img':
                        if (!data[ipt]) {
                            isCtrue('璇蜂笂浼犲皝闈㈠浘鐗�');return false;
                        }
                        break;
                    case 'detail_img':
                        if (!data[ipt]) {
                            if (data["type"] == 2) {
                                isCtrue('璇蜂笂浼犺鎯呭浘鐗�');return false;
                            }
                            if (data["type"] == 3) {
                                isCtrue('璇蜂笂浼犺棰戝皝闈�');return false;
                            }
                            break;
                        }
                    case 'video_url':
                        if (!data[ipt]) {
                            isCtrue('璇疯緭鍏ヨ烦杞湴鍧€');return false;
                        }
                        break;
                    case 'video_length':
                        if (!data[ipt]) {
                            isCtrue('璇疯緭鍏ヨ棰戦暱搴�');return false;
                        }
                        break;
                    case 'audio_name':
                        if (data[ipt] instanceof Array) {
                            for (i in data[ipt]) {
                                if (data[ipt][i] == "") {
                                    isCtrue('璇疯緭鍏ラ煶棰戞爣棰�');return false;
                                }
                                break;
                            }
                        } else {
                            if (!data[ipt]) {
                                isCtrue('璇疯緭鍏ラ煶棰戞爣棰�');return false;
                            } else {
                                data[ipt] = [data[ipt]];
                            }
                            break;
                        }
                    case 'audio_url':
                        if (data[ipt] instanceof Array) {
                            for (i in data[ipt]) {
                                if (data[ipt][i] == "") {
                                    isCtrue('璇蜂笂浼犻煶棰�');return false;
                                }
                                break;
                            }
                        } else {
                            if (!data[ipt]) {
                                isCtrue('璇蜂笂浼犻煶棰�');return false;
                            } else {
                                data[ipt] = [data[ipt]];
                            }
                            break;
                        }
                    case 'audio_length':
                        if (data[ipt] instanceof Array) {
                            for (i in data[ipt]) {
                                if (data[ipt][i] == "") {
                                    isCtrue('璇疯緭鍏ラ煶棰戦暱搴�');return false;
                                }
                                break;
                            }
                        } else {
                            if (!data[ipt]) {
                                isCtrue('璇疯緭鍏ラ煶棰戦暱搴�');return false;
                            } else {
                                data[ipt] = [data[ipt]];
                            }
                            break;
                        }
                    case 'detail_title':
                        if (!data[ipt]) {
                            isCtrue('璇疯緭鍏ヨ绋嬫爣棰�');return false;
                        }
                        break;
                    case 'content':
                        if (data[ipt] instanceof Array) {
                            for (i in data[ipt]) {
                                if (data[ipt][i] == "") {
                                    isCtrue('璇疯緭鍏ヨ绋嬪唴瀹�');return false;
                                }
                                break;
                            }
                        } else {
                            if (!data[ipt]) {
                                isCtrue('璇疯緭鍏ヨ绋嬪唴瀹�');return false;
                            } else {
                                data[ipt] = [data[ipt]];
                            }
                            break;
                        }
                    case 'imgUrl':
                        if (data[ipt] instanceof Array) {
                            for (i in data[ipt]) {
                                if (data[ipt][i] == "") {
                                    isCtrue('璇蜂笂浼犺绋嬪浘鐗�');return false;
                                }
                                break;
                            }
                        } else {
                            if (!data[ipt]) {
                                isCtrue('璇蜂笂浼犺绋嬪浘鐗�');return false;
                            } else {
                                data[ipt] = [data[ipt]];
                            }
                            break;
                        }
                }
            }
            // 鏁寸悊鏂囩珷鍐呭鏁版嵁
            data.detail_content = [];
            for (var j = 0; j < data.content.length; j++) {
                var json = {
                    "content": data.content[j],
                    "imgUrl": data.imgUrl[j]
                };
                data.detail_content.push(json);
            }
            // 鏁寸悊 闊抽鏁版嵁
            if (data.type == 2) {
                data.audiolist = [];
                for (var i = 0; i < data.audio_url.length; i++) {
                    var json = {
                        "audio_name": data.audio_name[i],
                        "audio_url": data.audio_url[i],
                        // "audio_length": data.audio_length[i],
                        "hour": data.hour[i],
                        "minute": data.minute[i],
                        "second": data.second[i]
                    };
                    data.audiolist.push(json);
                }
            }
            function isCtrue(text) {
                Ctrue = false;
                alert(text);
            };
            return Ctrue;
        }

        exports.jsAlert = jsAlert;
        exports.ajaxSubmit = ajaxSubmit;
        exports.yzForm = yzForm;

        /***/ },
    /* 11 */
    /***/ function(module, exports, __webpack_require__) {

        __webpack_require__(12);
        var url = __webpack_require__(7);

        var base = __webpack_require__(18);
        //妯℃澘閰嶇疆
        var tplArr = [];
        var template = __webpack_require__(8);
        var modalTpl = __webpack_require__(19);
        tplArr['modal'] = template.compile(modalTpl.replace(/^\s*|\s*$/g, ""));
        var baseTpl = __webpack_require__(20);
        tplArr['base'] = template.compile(baseTpl.replace(/^\s*|\s*$/g, ""));

        function Main() {
            _this = this;
            this.main = function () {
                this.event(this, 'click', 'm-click');
                //this.event(this,'click','a-click');
                this.init();
            };
            // this.event = function (_this, type, name) {
            //   $(document).on(type, '[' + name + ']', function (e) {
            //     var event = $($(this)[0]).attr(name);
            //     var Fun = event.split(',');
            //     _this[Fun[0]]($($(this)[0]), Fun[1], Fun[2], Fun[3], e);
            //   });
            // }
            // //浜嬩欢灏佽
            this.event = function (_this, type, name) {
                $(document).on(type, '[' + name + ']', function (e) {
                    //var ths = $(this)[0];
                    var event = $($(this)[0]).attr(name);
                    var Fun = event.split(',');
                    _this[Fun[0]]($($(this)[0]), Fun[1], e);
                });
            };
            //鍖哄垎鍏ㄥ崐瑙掑垽鏂枃瀛楅暱搴�
            this.getByteLen = function (val) {
                if (!val) {
                    val = 0;
                }
                var len = 0;
                for (var i = 0; i < val.length; i++) {
                    if (val.charAt(i).match(/[^\x00-\xff]/ig) != null) //鍏ㄨ
                        len += 2; //濡傛灉鏄叏瑙掞紝鍗犵敤涓や釜瀛楄妭
                    else len += 1; //鍗婅鍗犵敤涓€涓瓧鑺�
                }
                return len / 2;
            };
            //鑾峰彇url灞炴€у€�
            this.GetQueryString = function (name) {
                var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
                var url = decodeURI(window.location.search);
                var r = url.substr(1).match(reg);
                if (r != null) return unescape(r[2]);return null;
            };
            //鎻愮ず寮瑰嚭妗�
            this.alert = function (title, content) {
                var data = {
                    "Ttype": "alert",
                    title: title,
                    content: content
                };
                var alert = $(tplArr['modal'](data)).dialog("show");
                $('body').append(alert);
            };
            //鍏叡get鏂规硶
            this.get = function (url, data, Fun) {
                //data.openid_test= "ojtKJjq93sF3dOoz4lA12MrxtcUk";
                console.info(data);
                $.get(url, data, function (ret) {
                    Fun(ret);
                }, 'json');
            };
            //鍏叡post鏂规硶
            this.post = function (url, data, Fun) {
                //data.openid_test= "ojtKJjq93sF3dOoz4lA12MrxtcUk";
                $.post(url, data, function (ret) {
                    Fun(ret);
                }, 'json');
            };

            // 鍏叡ajax 鏂规硶
            this.myAjax = function (url, data, type, fn1, fn2) {
                $.ajax({
                    url: url,
                    data: data,
                    type: type,
                    dataType: "json",
                    success: function (re) {
                        fn1(re);
                    },
                    error: function (err) {
                        console.log(err);
                        fn2(err);
                    }
                });
            };

            //鎻愮ず寮瑰嚭妗�
            this.showAlert = function (options) {
                var data = {
                    "tType": "1",
                    "title": options.title || "鏍囬",
                    "info": options.info || '',
                    "cha": options.cha || '',
                    "btnEvent": options.btnEvent || 'm-click="closeDialog"',
                    "btnVal": options.btnVal || ''
                };
                var alert = tplArr['modal'](data);
                $('body').append(alert);
            };
            //涓ゆ寜閽彁绀哄脊鍑烘
            this.doubleBtnAlert = function (options) {
                var data = {
                    "tType": "btnModel",
                    "title": options.title || "鏍囬",
                    "info": options.info || '',
                    "btnList": options.btnList
                };
                var alert = tplArr['modal'](data);
                $('body').append(alert);
            };
            //鎻愮ず寮瑰嚭妗�
            this.alert = function (options) {
                var data = {
                    "Ttype": "alert",
                    "title": options.title || "鏍囬",
                    "closeFun": options.loseFun || 'm-click="alertClose"',
                    "content": options.content || "鍐呭"
                };
                console.log(data);
                var alert = $(tplArr['modal'](data)).dialog("show");
                $('body').append(alert);
            };
            //纭寮瑰嚭妗�
            this.confirm = function (options) {
                var data = {
                    "Ttype": "confirm",
                    "title": options.title || "鏍囬",
                    "eventFun": options.Fun || 'm-click="dialogClose"',
                    "closeFun": options.closeFun || 'm-click="dialogClose"',
                    "content": options.content || "鍐呭"
                };
                var alert = $(tplArr['modal'](data));
                $('body').append(alert);
            };
            //棰樼洰寮瑰嚭妗�
            this.questions = function (options) {
                var data = {
                    "Ttype": "questions",
                    "mark": options.mark,
                    "title": options.title || "鏍囬",
                    "eventFun": options.Fun || 'm-click="dialogClose"',
                    "closeFun": options.closeFun || 'm-click="dialogClose"',
                    "content": options.content || "鍐呭",
                    "left": options.left || "鎻愪氦",
                    "right": options.right || "鍙栨秷",
                    "starId": options.starId
                };
                var alert = $(tplArr['modal'](data)).dialog("show");
                $('body').append(alert);
            };
            //鍏抽棴鎻愮ず寮瑰嚭灞�
            this.dialogClose = function () {
                $('.ui-dialog').remove();
            };
            //鍏抽棴涓婄骇寮瑰嚭灞�
            this.alertClose = function () {
                $('#alert_dialog').remove();
            };
            //鍒涘缓鑿滃崟
            this.createMenu = function (menuData) {
                //璋冩帴鍙ｈ幏鍙栬彍鍗曞垪琛�
                //if(menuData){
                var data = {
                    "Ttype": "menu",
                    "menu": menuData
                };
                console.log(pageMenu);
                if ("undefined" == typeof pageMenu) {
                    console.log(menuData);
                    pageMenu = { "active": [menuData.dataList[0].id, menuData.dataList[0].list[0].id] };
                }
                data.menu.active = pageMenu.active;
                //$('.wrapper').prepend(tplArr['base'](data));
                // console.log(tplArr['base'](data), 11111);
                $('.main-sidebar').html(tplArr['base'](data));
                //}
            };
            this.getBrand = function (cb) {
                this.get(url.brand, {}, function (res) {
                    cb && cb(res);
                });
            };
            this.getTicket = function (appid, cb) {
                this.get(url.getCouponByBrand, { id: appid }, function (res) {
                    if (!res.data) {
                        res.data = [];
                    }
                    res.data.forEach(function (item) {
                        item.value = item.id;
                        item.text = item.title;
                    });
                    cb & cb(res.data);
                });
            };
            //鍒涘缓鍏叡澶�
            this.createHeader = function (data) {
                var data = {
                    "Ttype": "header",
                    "data": data
                };
                $('.main-header').html(tplArr['base'](data));
            };
            this.linkPage = function () {
                var appid = this.getCookie('id');
                console.log(appid, 8888);
                if (!!appid) {
                    // alert(111)
                    location.href = "http://www.woaap.com/home/" + appid;
                }
            };

            //鍒嗛〉
            //obj, total, pn, click, event, url
            this.getPages = function (data) {
                var _obj = data.obj;
                data.type = "pagination";
                data.list = this.getPageList(data.total, data.pcenter);
                console.log(data.list, 66666);
                _this.pageData = data;
                _obj.html(tplArr['base'](data));
            };
            this.getPageList = function (total, pcenter) {
                console.log(total, 55, pcenter);
                var pcenter = parseInt(pcenter),
                    _e = parseInt(total),
                    ret = [];
                if (_e <= 10) {
                    for (var i = 0; i < _e; i++) ret.push(i);
                } else {
                    //涓棿
                    if (pcenter - 5 > 0 && pcenter + 4 < _e) {
                        for (var i = pcenter - 5; i < pcenter + 5; i++) {
                            ret.push(i);
                        }
                    }
                    //鏈崄鏉�
                    else if (pcenter >= _e - 10 && pcenter > 5) {
                        for (var i = _e - 10; i < _e; i++) {
                            ret.push(i);
                        }
                    }
                    //澶村崄鏉�
                    else if (pcenter < 10) {
                        for (var i = 0; i < 10; i++) {
                            ret.push(i);
                        }
                    }
                    //闃查敊
                    else {
                        for (var i = pcenter - 5; i < pcenter + 5; i++) {
                            ret.push(i);
                        }
                    }
                }
                return ret;
            };
            //涓嬩竴椤�
            this.next = function (ths) {
                var data = _this.pageData,
                    pcenter = parseInt(data.pcenter) + 10;
                if (pcenter > parseInt(data.total) + 5) return;
                data.pcenter = pcenter;
                this.getPages(data);
            };
            //涓婁竴椤�
            this.prev = function (ths) {
                var data = _this.pageData,
                    pcenter = parseInt(data.pcenter) - 10;
                if (pcenter < -5) return;
                data.pcenter = pcenter;
                this.getPages(data);
            };
            this.setCookie = function (cname, cvalue, exdays) {
                var d = new Date();
                d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
                var expires = "expires=" + d.toGMTString();
                document.cookie = cname + "=" + cvalue + "; " + expires + "; path=/";
            };
            this.getCookie = function (cname) {
                var name = cname + "=";
                var ca = document.cookie.split(';');
                for (var i = 0; i < ca.length; i++) {
                    var c = ca[i].trim();
                    if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
                }
                return "";
            };
            this.init = function () {
                this.createMenu(base.menuData);
                var data1 = {
                    "username": base.username,
                    "editUrl": base.base_url + 'user/personalInformationIndex',
                    "loginout": base.base_url + 'login/loginOut'
                };
                this.createHeader(data1);

                //$(function() {
                //attachFastClick.attach(document.body);
                //});
            };
            return this.main();
        };
        //exports.orientLayer = orientLayer;

        var main = new Main();
        module.exports = main;

        /***/ },
    /* 12 */
    /***/ function(module, exports) {

        // removed by extract-text-webpack-plugin

        /***/ },
    /* 13 */,
    /* 14 */,
    /* 15 */,
    /* 16 */,
    /* 17 */,
    /* 18 */
    /***/ function(module, exports) {

        //涓昏彍鍗曟暟鎹�
        module.exports.menuData = menuinfo;
        module.exports.username = username;
        module.exports.base_url = base_url;
        // module.exports.menuData = {
        //     'active': [1],
        //     'dataList': [{
        //             'id': 1,
        //             'title': '璇剧▼绠＄悊',
        //             'icon': 'fa fa-folder-o',
        //             'url': '/html/course.html',
        //             'list': []
        //         }, {
        //             'id': 2,
        //             'title': '鍒嗙被绠＄悊',
        //             'icon': 'fa fa-folder-o',
        //             'url': '/html/classify.html',
        //             'list': []
        //         }, {
        //             'id': 3,
        //             'title': '娲诲姩绠＄悊',
        //             'icon': 'fa fa-folder-o',
        //             'url': '/html/act.html',
        //             'list': []
        //         }, {
        //             'id': 4,
        //             'title': '涓撳绠＄悊',
        //             'icon': 'fa fa-folder-o',
        //             'url': '/html/experts.html',
        //             'list': []
        //         }, {
        //             'id': 5,
        //             'title': '瑙掕壊绠＄悊',
        //             'icon': 'fa fa-folder-o',
        //             'url': '/html/role.html',
        //             'list': []
        //         },
        //         {
        //             'id': 6,
        //             'title': '淇敼璐﹀彿瀵嗙爜',
        //             'icon': 'fa fa-folder-o',
        //             'url': '/html/password.html',
        //             'list': []
        //         }]
        // }
        // var getdata = "getdata/"; //鍖哄垎鏈嶅姟鍣ㄦ帴鍙�
        // //var getdata = "http://cdcdemo.woaap.com/";//鍖哄垎鏈嶅姟鍣ㄦ帴鍙�
        // var getdata = "../../"; //鍖哄垎鏈嶅姟鍣ㄦ帴鍙�

        // //鍚庣鎺ュ彛璺緞
        // module.exports.url = {
        //   //涓氬姟缁撴瀯
        //   "structAll": getdata + "/struct/all", //涓氬姟缁撴瀯鏁翠綋鍏ㄩ儴
        //   "structView": getdata + "/struct/view", //涓氬姟缁撴瀯鏌ョ湅
        //   "structDel": getdata + "/struct/del", //涓氬姟缁撴瀯鍒犻櫎
        //   "structAdd": getdata + "/struct/add", //涓氬姟缁撴瀯娣诲姞
        //   "structEdit": getdata + "/struct/edit", //涓氬姟缁撴瀯缂栬緫
        // }
        module.exports.devUrl = "http://translite.woaap.com";

        /***/ },
    /* 19 */
    /***/ function(module, exports) {

        module.exports = "{{if Ttype == 'alert'}}\n<div class=\"ui-dialog\">\n    <div class=\"ui-dialog-cnt\">\n        <div class=\"ui-dialog-bd\">\n            <div>\n            <h4>{{title}}</h4>\n            <div>{{content}}</div></div>\n        </div>\n        <div class=\"ui-dialog-ft ui-btn-group\">\n            <button type=\"button\" data-role=\"button\" m-click=\"dialogClose\" class=\"select\" id=\"dialogButton{{i}}\">鍏抽棴</button> \n        </div>\n    </div>        \n</div>\n{{/if}}\n{{if Ttype == 'confirm'}}\n<div class=\"ui-dialog\">\n    <div class=\"ui-dialog-cnt\">\n        <div class=\"ui-dialog-bd\">\n            <div>\n            <h4>{{title}}</h4>\n            <div>{{content||\"test\"}}</div>\n            </div>\n        </div>\n        <div class=\"ui-dialog-ft ui-btn-group\">\n            <button type=\"button\" class=\"select\" {{eventFun}}>纭</button> \n            <button type=\"button\" {{closeFun}}  class=\"select\" id=\"dialogButton\">鍏抽棴</button> \n        </div>\n    </div>        \n</div>\n{{/if}}\n{{if Ttype== \"rules\"}}\n<div class=\"ui-dialog main-dialog\">\n    <div class=\"ui-dialog-cnt\">\n        <button type=\"button\" data-role=\"button\" class=\"close\"></button> \n        <div class=\"ui-dialog-bd\"> \n            <div class=\"title\">娲诲姩璇存槑</div>\n            <hr>\n            <div class=\"content\">\n                <p>鏈簰鍔ㄦ椿鍔ㄤ粎闄愪负鐖遍害璺戞椿鍔ㄧ幇鍦轰汉鍛樺弬涓庯紱</p><p>鍙備笌鑰呭湪浜掑姩娲诲姩涓幏寰楅害褰撳姵鎶樻墸鍒哥殑锛岄渶鍑數瀛愬厬鎹㈠埜鍓岴TOCRM灞曞彴鍏戞崲楹﹀綋鍔崇焊璐ㄦ姌鎵ｅ埜锛岀劧鍚庢柟鍙墠寰€楹﹀綋鍔冲疄浣撳簵鍑埜杩涜娑堣垂鎶电敤锛�</p><p>鍙備笌鑰呭湪浜掑姩娲诲姩涓幏寰楃ぜ鍝佸崱鍒稿悗锛屽彲鍑埜鍓嶅線ETOCRM灞曞彴鍏戞崲鐩稿簲瀹炵墿绀煎搧锛涚數瀛愬厬鎹㈠埜浠呴檺娲诲姩褰撴棩鐜板満鍏戞崲浣跨敤锛岄€炬湡鏃犳晥锛�</p><p>娲诲姩鏈€缁堣В閲婃潈褰掗綈鏁扮鎶€锛堜笂娴凤級鏈夐檺鍏徃鎵€鏈夈€�</p>\n            </div>\n        </div> \n        <div class=\"ui-dialog-ft\"></div>\n    </div>        \n</div>\n{{/if}}\n{{if Ttype== \"qrcode\"}}\n<div class=\"ui-dialog main-dialog\">\n    <div class=\"ui-dialog-cnt\">\n        <button type=\"button\" data-role=\"button\" class=\"close\"></button> \n        <div class=\"ui-dialog-bd\" style=\"width: 220px; margin-left: 22px;\"> \n            <div class=\"title\">缇や簩缁寸爜</div>\n            <hr>\n            <div class=\"content\">\n                <img src=\"{{baseUrl}}{{qrcode}}\" style=\"width: 100%;\">\n            </div>\n        </div> \n        <div class=\"ui-dialog-ft\"></div>\n    </div>        \n</div>\n{{/if}}\n<!-- 鏂板寮瑰嚭灞� -->\n<!--寮瑰嚭妗�-->\n{{if tType==\"1\"}}\n<div class=\"js_dialog\" id=\"iosDialog2\" style=\"opacity: 1;\">\n    <div class=\"weui-mask\"></div>\n    <div class=\"cancel-model\">\n        {{if cha==1}}\n            <span class=\"close\" m-click=\"closeDialog\">X</span>\n        {{/if}}\n        <h4>{{title}}</h4>\n        <p>{{info}}</p>\n        <button type=\"button\"  class=\"cancel-confirm\" {{btnEvent}}>{{btnVal}}</button>\n    </div>\n</div>\n{{/if}}\n<!-- 澶氭寜閽脊鍑哄眰 -->\n{{if tType==\"btnModel\"}}\n<div class=\"js_dialog\" id=\"iosDialog2\" style=\"opacity: 1;\">\n    <div class=\"weui-mask\"></div>\n    <div class=\"cancel-model\">\n        <!-- <span class=\"close\" m-click=\"closeDialog\">X</span> -->\n        <h4>{{title}}</h4>\n        <p>{{info}}</p>\n        {{each btnList as v i}}\n            <button type=\"button\" name=\"{{v.btnName}}\" class=\"cancel-confirm\"  {{v.btnEvent}} >{{v.btnVal}}</button>\n        {{/each}}\n    </div>\n</div>\n{{/if}}"

        /***/ },
    /* 20 */
    /***/ function(module, exports) {

        module.exports = "{{if Ttype == \"menu\"}}\n<!--宸︿晶鑿滃崟-->\n<section class=\"sidebar\">\n    <ul class=\"sidebar-menu\">\n        {{each menu.dataList as value i}}\n            {{if value.list.length == 0}}\n                <li class=\"{{ menu.active[0]==value.id?active='active':active=''}}\" name=\"tracking\">\n                    <a href=\"{{value.url}}\">\n                        <!-- <i class=\"{{value.icon}}\"></i>  -->\n                        <span>{{value.title}}</span>\n                    </a>\n                </li>\n            {{else}}\n                <li class=\"treeview {{menu.active[0]==value.id?active='active':active=''}}\">\n                    <a href=\"javascript:;\">\n                        <!-- <i class=\"{{value.icon}}\"></i>  -->\n                        <span>{{value.title}}</span>\n                    </a>\n                    <ul class=\"treeview-menu\" style=\"display:{{if menu.active[0]==value.id}}block{{else}}none{{/if}}\">\n                        {{each value.list as l m}}\n                            <li class=\"{{(menu.active[0]==value.id && menu.active[1] == l.id)?active:''}}\"><a href=\"{{l.url}}\" style=\"margin-left: 10px;\"><i class=\"fa fa-angle-double-right\"></i> {{l.title}}</a></li>\n                        {{/each}}\n                    </ul>\n                </li>\n            {{/if}}   \n        {{/each}}\n    </ul>\n</section>\n{{/if}}\n{{if Ttype == \"header\"}}\n<!-- Logo -->\n<a href=\"javascript:;\" class=\"logo\" style=\"padding:0\">\n  <!-- mini logo for sidebar mini 50x50 pixels -->\n  <span class=\"logo-mini\">\n    <img src=\"https://tc.woaap.com/yili/pc/img/u73.jpg\" width=\"100%\"; alt=\"\">\n  </span>\n  <!-- logo for regular state and mobile devices -->\n  <span class=\"logo-lg\">\n    <img src=\"https://tc.woaap.com/yilil/pc/img/u73.jpg\" width=\"100%\"; alt=\"\">\n    <!-- <span class=\"sidebar-tit\">POS鍚庡彴绠＄悊绯荤粺</span> -->\n  </span>\n</a>\n<!-- Header Navbar: style can be found in header.less -->\n<nav class=\"navbar navbar-static-top\">\n  <!-- Sidebar toggle button-->\n  <a href=\"#\" class=\"sidebar-toggle\" data-toggle=\"offcanvas\" role=\"button\">\n    <span class=\"sr-only\">Toggle navigation</span>\n    <span class=\"icon-bar\"></span>\n    <span class=\"icon-bar\"></span>\n    <span class=\"icon-bar\"></span>\n  </a>\n  <span class=\"sidebar-tit\" a-click=\"link\">鍚庡彴绠＄悊</span>\n  <!-- <span class=\"sidebar-tit margin_left\">2017-05-06</span> -->\n  <!-- 鐢ㄦ埛璁剧疆 -->\n  <div class=\"navbar-custom-menu\">\n    <ul class=\"nav navbar-nav\">\n      <li class=\"dropdown user user-menu\">\n        <!-- 鍘绘帀閫€鍑烘寜閽� -->\n        <!-- <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\"> -->\n        <a href=\"{{data.editUrl}}\" class=\"dropdown-toggle\" >\n          <!-- <img src=\"../../dist/img/avatar5.png\" class=\"user-image\" alt=\"User Image\"> -->\n          <span class=\"hidden-xs\">{{data.username}}</span>\n        </a>\n        <ul class=\"dropdown-menu\">\n          <li class=\"user-footer\">\n            <div class=\"pull-right\">\n                <span class=\"hidden-xs\">{{data.username}}</span>\n               <a href=\"{{data.loginout}}\" class=\"btn btn-default btn-flat\" style=\"margin-left: 10px;\">\n                  閫€鍑篭n              </a>\n              <!-- <a href=\"/logout\" class=\"btn btn-default btn-flat\">閫€鍑�</a> -->\n            </div>\n          </li>\n        </ul>\n      </li>\n    </ul>\n  </div>\n</nav>\n{{/if}}\n{{if type == \"pagination\"}}\n<li><a href=\"javascript:;\" m-click=\"prev\">芦</a></li>\n<!-- total, pn, click, event, url -->\n    {{each list as value i}}\n        {{if value+1 == pn}}\n        <li class=\"active\"><a href=\"javascript:;\">{{value+1}}</a></li>\n        {{else}}\n        <li><a href=\"javascript:;\" {{click}}=\"{{event}},{{url}}|{{value+1}}\">{{value+1}}</a></li>\n        {{/if}}\n    {{/each}}\n<li><a href=\"javascript:;\" m-click=\"next\">禄</a></li>\n{{/if}} "

        /***/ },
    /* 21 */,
    /* 22 */,
    /* 23 */
    /***/ function(module, exports) {

        $(window).resize(jsbox_csh);
        function jsbox_csh() {
            var zw = document.documentElement.clientWidth || document.body.clientWidth;
            var zh = document.documentElement.clientHeight || document.body.clientHeight;
            //	   var html_h = $("body").height();
            //	   alert(html_h);
            //	   $('#lightBox').height(html_h);
        }
        //$(window).ready(jsbox);

        var jsbox = function (_options) {

            var options_ = $.extend({
                onlyid: "", //寮瑰嚭灞侷D
                content: false, //鍐呭
                url: "", //鏁版嵁鍦板潃
                url_css: false, //鏍峰紡琛ㄥ湴鍧€
                iframe: false, //浣跨敤iframe
                ajax: false, //浣跨敤ajax
                loads: false, //浣跨敤load
                title: false, //鏍囬
                footer: false, //搴曢儴
                drag: false, //鎷栧姩
                slide: false, //寮瑰嚭鍚戜笅婊氬姩
                conw: 200, //瀹藉害
                //conh:400,//楂樺害
                FixedTop: false, //寮瑰嚭灞傚嚭鐜颁綅缃�
                FixedLeft: false, //寮瑰嚭灞傚嚭鐜颁綅缃�
                Opacity: .4, //閫忔槑搴�
                mack: false, //閬僵
                range: false, //绉诲姩鑼冨洿
                Save_button: false, //淇濆瓨鎸夐挳
                Ok_button: false, //纭畾鎸夐挳
                sd: "slow", //寮瑰嚭閫熷害
                Close: true,
                buttonCon: false,
                cancelBtn: false,
                loadFun: false,
                functions: false, //杩斿洖鍑芥暟
                Fun: false, //鍔犺浇瀹屾瘯鍥炶皟鏂规硶
                FunData: false,
                loadIcon: 'cj/jsbox/images_jsbox/loading.gif', //鍔犺浇鎻愮ず鍥剧墖璺緞
                error: '<h3>Error 404</h3>' //ajax鎶ラ敊淇℃伅
            }, _options || {});

            var zw = document.documentElement.clientWidth || document.body.clientWidth;
            var zh = document.documentElement.clientHeight || document.body.clientHeight;
            var optionsID = new Date().getTime();
            //var options = ".jsbox";
            var options = ".jsbox" + optionsID;
            this.show = function () {
                $("#" + options_.onlyid).remove();

                var wc = "";
                options_.FixedLeft != false ? wc = options_.FixedLeft : wc = zw / 2 - options_.conw / 2;

                var hc = "";
                options_.FixedTop != false ? hc = options_.FixedTop : hc = zh / 2 - 150;

                options_.buttonCon != false ? options_.buttonCon = options_.buttonCon : options_.buttonCon = "纭畾";
                options_.cancelBtn != false ? options_.cancelBtn = options_.cancelBtn : options_.cancelBtn = "鍙栨秷";

                var $show = $(options);
                var $tdcon = $('.centerCenter');
                var jsboxContent = $('.jsboxContent');
                var loading = $('<div class="loading"></div>');
                //var urlcss = $('<link rel="stylesheet" type="text/css" href="../../../../js/plug-in/jsbox/'+options_.url_css+'.css" />');
                var save_button = $("<div class='jsboxAn_save'><input class='btn btn-primary btn-flat btn-block' type='button' " + options_.Save_button + " value='" + options_.buttonCon + "'></div>");
                var ok_button = $("<div class='jsboxAn_ok'><input class='btn btn-primary btn-flat btn-block' type='button' " + options_.Ok_button + " value='" + options_.buttonCon + "'></div>");
                if (options_.Close == true) {
                    var Close = '<a href="javascript:void(0)" title="鍏抽棴" class="jsbox_close">';
                } else {
                    var Close = '<a style="display:none;" href="javascript:void(0)" title="鍏抽棴" class="jsbox_close">';
                }
                var boxtitle = $('<h2 class="jsboxTitle">' + options_.title + '</h2>' + Close + '</a>');
                var boxfooter = $("<div class='jsboxFooter'><div class='jsboxAn_Cancel'><input class='Cancel btn btn-default btn-flat btn-block' type='button' value='" + options_.cancelBtn + "'></div></div>");
                var zon = "<div class=\"popupComponent " + options_.onlyid + "_lightBox\" id=\"lightBox\"><div class=\"popupCover\"></div></div>";
                var con = "<div id='" + options_.onlyid + "' class='jsbox jsbox" + optionsID + "'>" + "<div class='jsboxContent' style='width:" + options_.conw + "px;height:" + options_.conh + "px;'></div>" + "</div>";

                if (options_.mack != false) {
                    var isclass = $('.popupComponent').is("." + options_.onlyid + "_lightBox");
                    if (!isclass) {
                        var leng = $('.popupComponent').length + 1;
                        var $zon = $(zon).appendTo('body').fadeTo("500", 1);
                        $zon.css({ 'zIndex': leng * 100 + 1000 - 10 });
                        var html_h = $("body").height();
                        var wid_h = $(window).height();
                        var mack_h = '';
                        if (html_h > wid_h) {
                            mack_h = html_h;
                        } else {
                            mack_h = wid_h;
                        };
                        $('.' + options_.onlyid + '_lightBox').show().height(mack_h);
                    }
                }

                var Tollp = $("html").scrollTop() || document.body.scrollTop | document.documentElement.scrollTop;
                var leng = $('.jsbox').length + 1;
                var $con = $(con).appendTo('body');
                $con.css({ 'zIndex': leng * 100 + 1000 });
                //$('body').css('overflow','hidden');

                $(options).css({ top: hc + Tollp - 50, left: wc - 10 }); //淇敼宸﹀畾浣嶏細left:wc
                var t = hc + Tollp - 50;
                //$('.jsboxContent').css('margin-top',t+'px');
                $(".topLeft,.topCenter,.topRight,.centerLeft,.centerRight,.bottomLeft,.bottomCenter,.bottomRight").fadeTo(20, options_.Opacity);

                var iframeh;
                if (options_.title != false && options_.footer != false) {
                    $('.jsboxContent', options).append(boxtitle);
                    $('.jsboxContent', options).append(boxfooter);
                    if (options_.Save_button != false) {
                        $(".jsboxFooter", options).prepend(save_button);
                    }
                    if (options_.Ok_button != false) {
                        $(".jsboxFooter", options).prepend(ok_button);
                    }
                    iframeh = options_.conh - 83;
                } else if (options_.title != false) {
                    $('.jsboxContent', options).append(boxtitle);
                    iframeh = options_.conh - 30;
                } else if (options_.footer != false) {
                    $('.jsboxContent', options).append(boxfooter);
                    iframeh = options_.conh - 48;
                    if (options_.Save_button != false) {
                        $(".jsboxFooter", options).prepend(save_button);
                    }
                    if (options_.Ok_button != false) {
                        $(".jsboxFooter", options).prepend(ok_button);
                    }
                } else {
                    iframeh = options_.conh;
                }

                var iframe = $('<iframe name="jsboxFrame" class="iframebox" style="width:100%; height:' + iframeh + 'px;" frameborder="no" border="0"></iframe>');
                var ajaxcon = $('<div class="jtycom" style="width:100%; height:' + iframeh + 'px;"></div>');
                var loaddiv = $('<div class="loaddiv" style="display:block; height:' + iframeh + 'px;"></div>');
                var content = $('<div class="loaddiv" style="display:block; height:' + iframeh + 'px;">' + options_.content + '</div>');

                if (options_.url != false && options_.iframe != false) {
                    $('.jsboxContent', options).append(loading);

                    if (options_.footer != false) {
                        $(".jsboxFooter", options).before(iframe);
                    } else {
                        $('.jsboxContent', options).append(iframe);
                    }

                    $('.iframebox', options).hide().attr("src", options_.url);
                    $('.iframebox', options).load(function () {
                        $(this).show();
                        $(".jsboxFooter", options).show();
                        loading.fadeTo(500, 0).hide();
                    });
                } else if (options_.url != false && options_.ajax != false) {
                    $('.jsboxContent', options).append(loading);

                    $.ajax({
                        url: options_.url,
                        type: 'GET',
                        dataType: 'json',
                        error: function () {
                            $('.jsboxContent', options).html(options_.error);
                        },
                        success: function (date) {

                            if (options_.url_css != false) {
                                //鍔犺浇鏍峰紡琛�
                                if ($("link[href$='" + options_.url_css + ".css']").length == 0) {
                                    var css_href = options_.url_css + '.css';
                                    var styleTag = document.createElement("link");
                                    styleTag.setAttribute('type', 'text/css');
                                    styleTag.setAttribute('rel', 'stylesheet');
                                    styleTag.setAttribute('href', css_href);
                                    $("head")[0].appendChild(styleTag);
                                }
                            }

                            $('.jsboxContent', options).append(ajaxcon);
                            loading.fadeTo(500, 0).hide();
                            if (options_.footer != false) {
                                $(".jsboxFooter", options).show();
                                $('.jsboxContent', options).append(boxfooter);
                            } else {
                                $('.jsboxContent', options).append(ajaxcon);
                            }
                            if (options_.content != false) {
                                options_.content(date);
                            };
                        }
                    });
                } else if (options_.url != false && options_.loads != false) {
                    //if(options_.url_css!=false){$('head').append(urlcss)}
                    $('.jsboxContent', options).append(loading);
                    if (options_.url_css != false) {
                        //鍔犺浇鏍峰紡琛�
                        if ($("link[href$='" + options_.url_css + ".css']").length == 0) {
                            var css_href = options_.url_css + '.css';
                            var styleTag = document.createElement("link");
                            styleTag.setAttribute('type', 'text/css');
                            styleTag.setAttribute('rel', 'stylesheet');
                            styleTag.setAttribute('href', css_href);
                            $("head")[0].appendChild(styleTag);
                        }
                    }

                    if (options_.footer != false) {
                        $(".jsboxFooter", options).before(loaddiv);
                    } else {
                        $('.jsboxContent', options).append(loaddiv);
                    }

                    //$('.jsboxContent',options).append(loading);
                    $('.loaddiv', options).load(options_.url, function () {
                        if (options_.loadFun) {
                            options_.loadFun();
                        }
                        loading.hide();
                        $(".jsboxFooter", options).show();

                        if (options_.Fun) {
                            if (options_.FunData) {
                                alert(options_.FunData);
                                options_.Fun(options_.onlyid, options_.FunData);
                            } else {
                                options_.Fun(options_.onlyid);
                            }
                        }
                        if (options_.functions != false) {
                            //loadfun();
                            $('.loaddiv').css({ "background": "none" });
                        }
                    });
                } else {

                    if (options_.footer != false) {
                        $(".jsboxFooter", options).before(content);
                    } else {
                        $('.jsboxContent', options).append(content);
                    }
                    $(".jsboxFooter", options).show();
                }

                if (options_.Fun) {
                    if (options_.FunData) {
                        options_.Fun(options_.onlyid, options_.FunData);
                    } else {
                        options_.Fun(options_.onlyid);
                    }
                }

                //if(!$show.is(":animated") ){
                if (options_.drag != false) {
                    jsbox_yd();
                } else {
                    jsbox_hd(options_.sd);
                }
                if (options_.slide != false) {
                    jsbox_hdx();
                } else {
                    jsbox_hd();
                }
                //}

                //        $(".jsboxAn_Cancel",options).die().on('click',function(){
                // $(this).parents(options).remove();
                // $('.'+options_.onlyid+'_lightBox').remove();
                //             $('body').css('overflow','auto');
                //  });
                //  $(".jsbox_close",options).on('click',function(){
                // $(this).parents(options).remove();
                // $('.'+options_.onlyid+'_lightBox').remove();
                //             $('body').css('overflow','auto');
                //  });

                $(document).on('click', ".jsboxAn_Cancel", function () {
                    var ths = $(this)[0];
                    $(ths).parents(options).remove();
                    $('.' + options_.onlyid + '_lightBox').remove();
                    $('body').css('overflow', 'auto');
                });

                $(document).on('click', ".jsbox_close", function () {
                    var ths = $(this)[0];
                    $(ths).parents(options).remove();
                    $('.' + options_.onlyid + '_lightBox').remove();
                    $('body').css('overflow', 'auto');
                });
            };

            //绉诲姩
            var jsbox_yd = function () {
                var _move = false; //绉诲姩鏍囪
                var _x, _y; //榧犳爣绂绘帶浠跺乏涓婅鐨勭浉瀵逛綅缃�

                $(".jsboxTitle", options).mousedown(function (e) {
                    _move = true;
                    _x = e.pageX - parseInt($(options).css("left"));
                    _y = e.pageY - parseInt($(options).css("top"));

                    //z-index
                    if ($(".index_z").length == 0) {
                        $("body").append('<input class="index_z"type="hidden" value="1300"/>');
                    }
                    var zzs = $(".index_z").val() * 1 + 1;
                    var zjleng = $(".index_z").val(zzs);
                    $(options).css({ "z-index": zzs });

                    $('.ud').text(_y);
                });

                //	$(".jsboxTitle",options).mouseup(function(e){
                //		$('.ud').text('鏀惧紑');
                //	    _move=false;
                //
                //    });

                var zsw = $(options).width();
                var zsh = $(options).height();

                var zws = document.documentElement.clientWidth || document.body.clientWidth;
                var zhs = document.documentElement.clientHeight || document.body.clientHeight;
                var obje = $(options);
                $(document).mousemove(function (e) {
                    if (_move) {

                        var ws = zws - zsw;
                        var hs = zhs - zsh;
                        var x = e.pageX - _x; //绉诲姩鏃舵牴鎹紶鏍囦綅缃绠楁帶浠跺乏涓婅鐨勭粷瀵逛綅缃�
                        var y = e.pageY - _y;
                        if (options_.range != false) {
                            if (x <= 0) {
                                x = 0;
                            }
                            if (x >= ws) {
                                x = ws;
                            }
                            if (y <= 0) {
                                y = 0;
                            }
                            if (y >= hs) {
                                y = hs;
                            }
                        }
                        obje.css({ top: y, left: x }); //鎺т欢鏂颁綅缃�
                    }
                }).mouseup(function () {
                    _move = false;
                    return false;
                });
            };

            function jsbox_hd(sd) {
                $(options).fadeIn(sd);
            }
            function jsbox_hdx() {
                $(options).fadeIn('slow').animate({ opacity: '100', top: "+=50" }, 'slow');
            }
        };

        // var jsbox = new jsbox();
        module.exports = jsbox;

        /***/ }
    /******/ ]);