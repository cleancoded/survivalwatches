(window.webpackWcBlocksJsonp=window.webpackWcBlocksJsonp||[]).push([[16],{157:function(t,e,c){"use strict";var n=c(0),r=c(118),o=c(88),a=function(t){var e=t.indexOf("</p>");return-1===e?t:t.substr(0,e+4)},u=function(t){return t.replace(/<\/?[a-z][^>]*?>/gi,"")},s=function(t,e){return t.replace(/[\s|\.\,]+$/i,"")+e},i=function(t,e){var c=arguments.length>2&&void 0!==arguments[2]?arguments[2]:"&hellip;",n=u(t),r=n.split(" ").splice(0,e).join(" ");return Object(o.autop)(s(r,c))},l=function(t,e){var c=!(arguments.length>2&&void 0!==arguments[2])||arguments[2],n=arguments.length>3&&void 0!==arguments[3]?arguments[3]:"&hellip;",r=u(t),a=r.slice(0,e);if(c)return Object(o.autop)(s(a,n));var i=a.match(/([\s]+)/g),l=i?i.length:0,p=r.slice(0,e+l);return Object(o.autop)(s(p,n))};e.a=function(t){var e=t.source,c=t.maxLength,u=void 0===c?15:c,s=t.countType,p=void 0===s?"words":s,d=t.className,m=void 0===d?"":d,v=Object(n.useMemo)((function(){return function(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:15,c=arguments.length>2&&void 0!==arguments[2]?arguments[2]:"words",n=Object(o.autop)(t),u=Object(r.count)(n,c);if(u<=e)return n;var s=a(n),p=Object(r.count)(s,c);return p<=e?s:"words"===c?i(s,e):l(s,e,"characters_including_spaces"===c)}(e,u,p)}),[e,u,p]);return Object(n.createElement)(n.RawHTML,{className:m},v)}},483:function(t,e,c){"use strict";c.r(e);var n=c(5),r=c.n(n),o=c(0),a=(c(2),c(6)),u=c.n(a),s=c(157),i=c(11),l=c(44),p=c(82);c(538),e.default=Object(p.withProductDataContext)((function(t){var e=t.className,c=Object(l.useInnerBlockLayoutContext)().parentClassName,n=Object(l.useProductDataContext)().product;if(!n)return Object(o.createElement)("div",{className:u()(e,"wc-block-components-product-summary",r()({},"".concat(c,"__product-summary"),c))});var a=n.short_description?n.short_description:n.description;return a?Object(o.createElement)(s.a,{className:u()(e,"wc-block-components-product-summary",r()({},"".concat(c,"__product-summary"),c)),source:a,maxLength:150,countType:i.q.wordCountType||"words"}):null}))},538:function(t,e){}}]);