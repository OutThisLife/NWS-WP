(function(){var r;r=angular.module("app.filters",[]),r.filter("trust",["$sce",function(r){return function(n){return r.trustAsResourceUrl(n)}}]),r.filter("nl2br",function(){return function(r){return null!=r?r.replace(/\n/g,"<br />"):void 0}}),r.filter("reverse",function(){return function(r){return r.slice().reverse()}}),r.filter("objLength",function(){return function(r){var n,t;n=1;for(t in r)n++;return n}}),r.filter("parseUrl",function(){var r;return r=/(http|ftp|https):\/\/[\w-]+(\.[\w-]+)+([\w.,@?^=%&amp;:\/~+#-]*[\w@?^=%&amp;\/~+#-])?/gi,function(n,t){return null==t&&(t="_blank"),angular.forEach(n.match(r),function(r){return n=n.replace(r,"<a target="+t+" href="+r+">"+r+"</a>")}),n}})}).call(this);