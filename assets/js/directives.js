var app;app=angular.module("app.directives",[]),app.directive("ngHoverintent",function(){return{restrict:"A",scope:!0,link:function(n,r){return require(["hoverintent"],function(){var n;return n=function(n,r){var e;return 1===(e=n.find("> ul")).length?n.add(e)[r]("over"):void 0},r.find("li").hoverIntent({interval:5,timeout:25,over:function(){return n($(this),"addClass")},out:function(){return n($(this),"removeClass")}})})}}}),app.directive("ngSlideshow",function(){return{restrict:"A",scope:!0,controller:["$scope",function(n){return n.next=function(){return n.current+=1},n.prev=function(){return n.current-=1}}],link:function(n,r){return n.el=$(r),n.current=0,n.max=$(r).find("figure").length,require(["hammer"],function(){var r;return r=n.el.hammer(),r.on("swipeleft",function(){return n.next()}),r.on("swiperight",function(){return n.prev()})})}}});