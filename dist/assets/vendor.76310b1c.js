var X=typeof globalThis!="undefined"?globalThis:typeof window!="undefined"?window:typeof global!="undefined"?global:typeof self!="undefined"?self:{},ut={exports:{}};(function(D){var d={scope:{}};d.defineProperty=typeof Object.defineProperties=="function"?Object.defineProperty:function(s,y,h){if(h.get||h.set)throw new TypeError("ES3 does not support getters and setters.");s!=Array.prototype&&s!=Object.prototype&&(s[y]=h.value)},d.getGlobal=function(s){return typeof window!="undefined"&&window===s?s:typeof X!="undefined"&&X!=null?X:s},d.global=d.getGlobal(X),d.SYMBOL_PREFIX="jscomp_symbol_",d.initSymbol=function(){d.initSymbol=function(){},d.global.Symbol||(d.global.Symbol=d.Symbol)},d.symbolCounter_=0,d.Symbol=function(s){return d.SYMBOL_PREFIX+(s||"")+d.symbolCounter_++},d.initSymbolIterator=function(){d.initSymbol();var s=d.global.Symbol.iterator;s||(s=d.global.Symbol.iterator=d.global.Symbol("iterator")),typeof Array.prototype[s]!="function"&&d.defineProperty(Array.prototype,s,{configurable:!0,writable:!0,value:function(){return d.arrayIterator(this)}}),d.initSymbolIterator=function(){}},d.arrayIterator=function(s){var y=0;return d.iteratorPrototype(function(){return y<s.length?{done:!1,value:s[y++]}:{done:!0}})},d.iteratorPrototype=function(s){return d.initSymbolIterator(),s={next:s},s[d.global.Symbol.iterator]=function(){return this},s},d.array=d.array||{},d.iteratorFromArray=function(s,y){d.initSymbolIterator(),s instanceof String&&(s+="");var h=0,v={next:function(){if(h<s.length){var S=h++;return{value:y(S,s[S]),done:!1}}return v.next=function(){return{done:!0,value:void 0}},v.next()}};return v[Symbol.iterator]=function(){return v},v},d.polyfill=function(s,y,h,v){if(y){for(h=d.global,s=s.split("."),v=0;v<s.length-1;v++){var S=s[v];S in h||(h[S]={}),h=h[S]}s=s[s.length-1],v=h[s],y=y(v),y!=v&&y!=null&&d.defineProperty(h,s,{configurable:!0,writable:!0,value:y})}},d.polyfill("Array.prototype.keys",function(s){return s||function(){return d.iteratorFromArray(this,function(y){return y})}},"es6-impl","es3");var at=X;(function(s,y){D.exports?D.exports=y():s.anime=y()})(X,function(){function s(t){if(!f.col(t))try{return document.querySelectorAll(t)}catch{}}function y(t,r){for(var n=t.length,e=2<=arguments.length?arguments[1]:void 0,o=[],u=0;u<n;u++)if(u in t){var a=t[u];r.call(e,a,u,t)&&o.push(a)}return o}function h(t){return t.reduce(function(r,n){return r.concat(f.arr(n)?h(n):n)},[])}function v(t){return f.arr(t)?t:(f.str(t)&&(t=s(t)||t),t instanceof NodeList||t instanceof HTMLCollection?[].slice.call(t):[t])}function S(t,r){return t.some(function(n){return n===r})}function B(t){var r={},n;for(n in t)r[n]=t[n];return r}function Q(t,r){var n=B(t),e;for(e in t)n[e]=r.hasOwnProperty(e)?r[e]:t[e];return n}function _(t,r){var n=B(t),e;for(e in r)n[e]=f.und(t[e])?r[e]:t[e];return n}function st(t){t=t.replace(/^#?([a-f\d])([a-f\d])([a-f\d])$/i,function(e,o,u,a){return o+o+u+u+a+a});var r=/^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(t);t=parseInt(r[1],16);var n=parseInt(r[2],16),r=parseInt(r[3],16);return"rgba("+t+","+n+","+r+",1)"}function ft(t){function r(l,g,c){return 0>c&&(c+=1),1<c&&--c,c<1/6?l+6*(g-l)*c:.5>c?g:c<2/3?l+(g-l)*(2/3-c)*6:l}var n=/hsl\((\d+),\s*([\d.]+)%,\s*([\d.]+)%\)/g.exec(t)||/hsla\((\d+),\s*([\d.]+)%,\s*([\d.]+)%,\s*([\d.]+)\)/g.exec(t);t=parseInt(n[1])/360;var e=parseInt(n[2])/100,o=parseInt(n[3])/100,n=n[4]||1;if(e==0)o=e=t=o;else{var u=.5>o?o*(1+e):o+e-o*e,a=2*o-u,o=r(a,u,t+1/3),e=r(a,u,t);t=r(a,u,t-1/3)}return"rgba("+255*o+","+255*e+","+255*t+","+n+")"}function Y(t){if(t=/([\+\-]?[0-9#\.]+)(%|px|pt|em|rem|in|cm|mm|ex|ch|pc|vw|vh|vmin|vmax|deg|rad|turn)?$/.exec(t))return t[2]}function lt(t){if(-1<t.indexOf("translate")||t==="perspective")return"px";if(-1<t.indexOf("rotate")||-1<t.indexOf("skew"))return"deg"}function G(t,r){return f.fnc(t)?t(r.target,r.id,r.total):t}function k(t,r){if(r in t.style)return getComputedStyle(t).getPropertyValue(r.replace(/([a-z])([A-Z])/g,"$1-$2").toLowerCase())||"0"}function H(t,r){if(f.dom(t)&&S(wt,r))return"transform";if(f.dom(t)&&(t.getAttribute(r)||f.svg(t)&&t[r]))return"attribute";if(f.dom(t)&&r!=="transform"&&k(t,r))return"css";if(t[r]!=null)return"object"}function ct(t,r){var n=lt(r),n=-1<r.indexOf("scale")?1:0+n;if(t=t.style.transform,!t)return n;for(var e=[],o=[],u=[],a=/(\w+)\((.+?)\)/g;e=a.exec(t);)o.push(e[1]),u.push(e[2]);return t=y(u,function(l,g){return o[g]===r}),t.length?t[0]:n}function J(t,r){switch(H(t,r)){case"transform":return ct(t,r);case"css":return k(t,r);case"attribute":return t.getAttribute(r)}return t[r]||0}function K(t,r){var n=/^(\*=|\+=|-=)/.exec(t);if(!n)return t;var e=Y(t)||0;switch(r=parseFloat(r),t=parseFloat(t.replace(n[0],"")),n[0][0]){case"+":return r+t+e;case"-":return r-t+e;case"*":return r*t+e}}function z(t,r){return Math.sqrt(Math.pow(r.x-t.x,2)+Math.pow(r.y-t.y,2))}function U(t){t=t.points;for(var r=0,n,e=0;e<t.numberOfItems;e++){var o=t.getItem(e);0<e&&(r+=z(n,o)),n=o}return r}function W(t){if(t.getTotalLength)return t.getTotalLength();switch(t.tagName.toLowerCase()){case"circle":return 2*Math.PI*t.getAttribute("r");case"rect":return 2*t.getAttribute("width")+2*t.getAttribute("height");case"line":return z({x:t.getAttribute("x1"),y:t.getAttribute("y1")},{x:t.getAttribute("x2"),y:t.getAttribute("y2")});case"polyline":return U(t);case"polygon":var r=t.points;return U(t)+z(r.getItem(r.numberOfItems-1),r.getItem(0))}}function dt(t,r){function n(a){return a=a===void 0?0:a,t.el.getPointAtLength(1<=r+a?r+a:0)}var e=n(),o=n(-1),u=n(1);switch(t.property){case"x":return e.x;case"y":return e.y;case"angle":return 180*Math.atan2(u.y-o.y,u.x-o.x)/Math.PI}}function tt(t,r){var n=/-?\d*\.?\d+/g,e;if(e=f.pth(t)?t.totalLength:t,f.col(e))if(f.rgb(e)){var o=/rgb\((\d+,\s*[\d]+,\s*[\d]+)\)/g.exec(e);e=o?"rgba("+o[1]+",1)":e}else e=f.hex(e)?st(e):f.hsl(e)?ft(e):void 0;else o=(o=Y(e))?e.substr(0,e.length-o.length):e,e=r&&!/\s/g.test(e)?o+r:o;return e+="",{original:e,numbers:e.match(n)?e.match(n).map(Number):[0],strings:f.str(t)||r?e.split(n):[]}}function rt(t){return t=t?h(f.arr(t)?t.map(v):v(t)):[],y(t,function(r,n,e){return e.indexOf(r)===n})}function pt(t){var r=rt(t);return r.map(function(n,e){return{target:n,id:e,total:r.length}})}function gt(t,r){var n=B(r);if(f.arr(t)){var e=t.length;e!==2||f.obj(t[0])?f.fnc(r.duration)||(n.duration=r.duration/e):t={value:t}}return v(t).map(function(o,u){return u=u?0:r.delay,o=f.obj(o)&&!f.pth(o)?o:{value:o},f.und(o.delay)&&(o.delay=u),o}).map(function(o){return _(o,n)})}function yt(t,r){var n={},e;for(e in t){var o=G(t[e],r);f.arr(o)&&(o=o.map(function(u){return G(u,r)}),o.length===1&&(o=o[0])),n[e]=o}return n.duration=parseFloat(n.duration),n.delay=parseFloat(n.delay),n}function mt(t){return f.arr(t)?V.apply(this,t):ot[t]}function ht(t,r){var n;return t.tweens.map(function(e){e=yt(e,r);var o=e.value,u=J(r.target,t.name),a=n?n.to.original:u,a=f.arr(o)?o[0]:a,l=K(f.arr(o)?o[1]:o,a),u=Y(l)||Y(a)||Y(u);return e.from=tt(a,u),e.to=tt(l,u),e.start=n?n.end:t.offset,e.end=e.start+e.delay+e.duration,e.easing=mt(e.easing),e.elasticity=(1e3-Math.min(Math.max(e.elasticity,1),999))/1e3,e.isPath=f.pth(o),e.isColor=f.col(e.from.original),e.isColor&&(e.round=1),n=e})}function vt(t,r){return y(h(t.map(function(n){return r.map(function(e){var o=H(n.target,e.name);if(o){var u=ht(e,n);e={type:o,property:e.name,animatable:n,tweens:u,duration:u[u.length-1].end,delay:u[0].delay}}else e=void 0;return e})})),function(n){return!f.und(n)})}function et(t,r,n,e){var o=t==="delay";return r.length?(o?Math.min:Math.max).apply(Math,r.map(function(u){return u[t]})):o?e.delay:n.offset+e.delay+e.duration}function xt(t){var r=Q(bt,t),n=Q(nt,t),e=pt(t.targets),o=[],u=_(r,n),a;for(a in t)u.hasOwnProperty(a)||a==="targets"||o.push({name:a,offset:u.offset,tweens:gt(t[a],n)});return t=vt(e,o),_(r,{children:[],animatables:e,animations:t,duration:et("duration",t,r,n),delay:et("delay",t,r,n)})}function b(t){function r(){return window.Promise&&new Promise(function(p){return I=p})}function n(p){return i.reversed?i.duration-p:p}function e(p){for(var x=0,L={},j=i.animations,q=j.length;x<q;){var T=j[x],A=T.animatable,w=T.tweens,M=w.length-1,m=w[M];M&&(m=y(w,function(Mt){return p<Mt.end})[0]||m);for(var w=Math.min(Math.max(p-m.start-m.delay,0),m.duration)/m.duration,C=isNaN(w)?1:m.easing(w,m.elasticity),w=m.to.strings,N=m.round,M=[],E=void 0,E=m.to.numbers.length,F=0;F<E;F++){var $=void 0,$=m.to.numbers[F],it=m.from.numbers[F],$=m.isPath?dt(m.value,C*$):it+C*($-it);N&&(m.isColor&&2<F||($=Math.round($*N)/N)),M.push($)}if(m=w.length)for(E=w[0],C=0;C<m;C++)N=w[C+1],F=M[C],isNaN(F)||(E=N?E+(F+N):E+(F+" "));else E=M[0];At[T.type](A.target,T.property,E,L,A.id),T.currentValue=E,x++}if(x=Object.keys(L).length)for(j=0;j<x;j++)R||(R=k(document.body,"transform")?"transform":"-webkit-transform"),i.animatables[j].target.style[R]=L[j].join(" ");i.currentTime=p,i.progress=p/i.duration*100}function o(p){i[p]&&i[p](i)}function u(){i.remaining&&i.remaining!==!0&&i.remaining--}function a(p){var x=i.duration,L=i.offset,j=L+i.delay,q=i.currentTime,T=i.reversed,A=n(p);if(i.children.length){var w=i.children,M=w.length;if(A>=i.currentTime)for(var m=0;m<M;m++)w[m].seek(A);else for(;M--;)w[M].seek(A)}(A>=j||!x)&&(i.began||(i.began=!0,o("begin")),o("run")),A>L&&A<x?e(A):(A<=L&&q!==0&&(e(0),T&&u()),(A>=x&&q!==x||!x)&&(e(x),T||u())),o("update"),p>=x&&(i.remaining?(g=l,i.direction==="alternate"&&(i.reversed=!i.reversed)):(i.pause(),i.completed||(i.completed=!0,o("complete"),"Promise"in window&&(I(),P=r()))),c=0)}t=t===void 0?{}:t;var l,g,c=0,I=null,P=r(),i=xt(t);return i.reset=function(){var p=i.direction,x=i.loop;for(i.currentTime=0,i.progress=0,i.paused=!0,i.began=!1,i.completed=!1,i.reversed=p==="reverse",i.remaining=p==="alternate"&&x===1?2:x,e(0),p=i.children.length;p--;)i.children[p].reset()},i.tick=function(p){l=p,g||(g=l),a((c+l-g)*b.speed)},i.seek=function(p){a(n(p))},i.pause=function(){var p=O.indexOf(i);-1<p&&O.splice(p,1),i.paused=!0},i.play=function(){i.paused&&(i.paused=!1,g=0,c=n(i.currentTime),O.push(i),Z||It())},i.reverse=function(){i.reversed=!i.reversed,g=0,c=n(i.currentTime)},i.restart=function(){i.pause(),i.reset(),i.play()},i.finished=P,i.reset(),i.autoplay&&i.play(),i}var bt={update:void 0,begin:void 0,run:void 0,complete:void 0,loop:1,direction:"normal",autoplay:!0,offset:0},nt={duration:1e3,delay:0,easing:"easeOutElastic",elasticity:500,round:0},wt="translateX translateY translateZ rotate rotateX rotateY rotateZ scale scaleX scaleY scaleZ skewX skewY perspective".split(" "),R,f={arr:function(t){return Array.isArray(t)},obj:function(t){return-1<Object.prototype.toString.call(t).indexOf("Object")},pth:function(t){return f.obj(t)&&t.hasOwnProperty("totalLength")},svg:function(t){return t instanceof SVGElement},dom:function(t){return t.nodeType||f.svg(t)},str:function(t){return typeof t=="string"},fnc:function(t){return typeof t=="function"},und:function(t){return typeof t=="undefined"},hex:function(t){return/(^#[0-9A-F]{6}$)|(^#[0-9A-F]{3}$)/i.test(t)},rgb:function(t){return/^rgb/.test(t)},hsl:function(t){return/^hsl/.test(t)},col:function(t){return f.hex(t)||f.rgb(t)||f.hsl(t)}},V=function(){function t(r,n,e){return(((1-3*e+3*n)*r+(3*e-6*n))*r+3*n)*r}return function(r,n,e,o){if(0<=r&&1>=r&&0<=e&&1>=e){var u=new Float32Array(11);if(r!==n||e!==o)for(var a=0;11>a;++a)u[a]=t(.1*a,r,e);return function(l){if(r===n&&e===o)return l;if(l===0)return 0;if(l===1)return 1;for(var g=0,c=1;c!==10&&u[c]<=l;++c)g+=.1;--c;var c=g+(l-u[c])/(u[c+1]-u[c])*.1,I=3*(1-3*e+3*r)*c*c+2*(3*e-6*r)*c+3*r;if(.001<=I){for(g=0;4>g&&(I=3*(1-3*e+3*r)*c*c+2*(3*e-6*r)*c+3*r,I!==0);++g)var P=t(c,r,e)-l,c=c-P/I;l=c}else if(I===0)l=c;else{var c=g,g=g+.1,i=0;do P=c+(g-c)/2,I=t(P,r,e)-l,0<I?g=P:c=P;while(1e-7<Math.abs(I)&&10>++i);l=P}return t(l,n,o)}}}}(),ot=function(){function t(a,l){return a===0||a===1?a:-Math.pow(2,10*(a-1))*Math.sin(2*(a-1-l/(2*Math.PI)*Math.asin(1))*Math.PI/l)}var r="Quad Cubic Quart Quint Sine Expo Circ Back Elastic".split(" "),n={In:[[.55,.085,.68,.53],[.55,.055,.675,.19],[.895,.03,.685,.22],[.755,.05,.855,.06],[.47,0,.745,.715],[.95,.05,.795,.035],[.6,.04,.98,.335],[.6,-.28,.735,.045],t],Out:[[.25,.46,.45,.94],[.215,.61,.355,1],[.165,.84,.44,1],[.23,1,.32,1],[.39,.575,.565,1],[.19,1,.22,1],[.075,.82,.165,1],[.175,.885,.32,1.275],function(a,l){return 1-t(1-a,l)}],InOut:[[.455,.03,.515,.955],[.645,.045,.355,1],[.77,0,.175,1],[.86,0,.07,1],[.445,.05,.55,.95],[1,0,0,1],[.785,.135,.15,.86],[.68,-.55,.265,1.55],function(a,l){return .5>a?t(2*a,l)/2:1-t(-2*a+2,l)/2}]},e={linear:V(.25,.25,.75,.75)},o={},u;for(u in n)o.type=u,n[o.type].forEach(function(a){return function(l,g){e["ease"+a.type+r[g]]=f.fnc(l)?l:V.apply(at,l)}}(o)),o={type:o.type};return e}(),At={css:function(t,r,n){return t.style[r]=n},attribute:function(t,r,n){return t.setAttribute(r,n)},object:function(t,r,n){return t[r]=n},transform:function(t,r,n,e,o){e[o]||(e[o]=[]),e[o].push(r+"("+n+")")}},O=[],Z=0,It=function(){function t(){Z=requestAnimationFrame(r)}function r(n){var e=O.length;if(e){for(var o=0;o<e;)O[o]&&O[o].tick(n),o++;t()}else cancelAnimationFrame(Z),Z=0}return t}();return b.version="2.2.0",b.speed=1,b.running=O,b.remove=function(t){t=rt(t);for(var r=O.length;r--;)for(var n=O[r],e=n.animations,o=e.length;o--;)S(t,e[o].animatable.target)&&(e.splice(o,1),e.length||n.pause())},b.getValue=J,b.path=function(t,r){var n=f.str(t)?s(t)[0]:t,e=r||100;return function(o){return{el:n,property:o,totalLength:W(n)*(e/100)}}},b.setDashoffset=function(t){var r=W(t);return t.setAttribute("stroke-dasharray",r),r},b.bezier=V,b.easings=ot,b.timeline=function(t){var r=b(t);return r.pause(),r.duration=0,r.add=function(n){return r.children.forEach(function(e){e.began=!0,e.completed=!0}),v(n).forEach(function(e){var o=_(e,Q(nt,t||{}));o.targets=o.targets||t.targets,e=r.duration;var u=o.offset;o.autoplay=!1,o.direction=r.direction,o.offset=f.und(u)?e:K(u,e),r.began=!0,r.completed=!0,r.seek(o.offset),o=b(o),o.began=!0,o.completed=!0,o.duration>e&&(r.duration=o.duration),r.children.push(o)}),r.seek(0),r.reset(),r.autoplay&&r.restart(),r},r},b.random=function(t,r){return Math.floor(Math.random()*(r-t+1))+t},b})})(ut);var St=ut.exports;export{St as a};
