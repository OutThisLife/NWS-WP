(function() {
  var $body, app, docObj, winObj;

  app = angular.module('app.controllers', []);

  winObj = angular.element(window);

  docObj = angular.element(document);

  $body = angular.element('body, html');

  app.controller('Main', [
    '$scope', '$timeout', '$interval', function($scope, $timeout, $interval) {
      var globalDimensions;
      globalDimensions = function() {
        $scope.winWidth = winObj.width();
        $scope.winHeight = winObj.height();
        return $scope.scrollTop = winObj.scrollTop();
      };
      $timeout(globalDimensions);
      return $interval(globalDimensions, 25);
    }
  ]);

}).call(this);

(function() {
  angular.element(document).ready(function() {
    angular.module('app', ['ngTouch', 'app.controllers', 'app.directives', 'app.services', 'app.filters']);
    return angular.bootstrap(document, ['app']);
  });

}).call(this);

(function() {
  var $body, app, raf, winObj;

  app = angular.module('app.directives', []);

  $body = angular.element('body, html');

  winObj = angular.element(window);

  raf = (function() {
    return window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || window.oRequestAnimationFrame || window.msRequestAnimationFrame || function(callback) {
      return window.setTimeout(callback, 1);
    };
  })();

  app.directive('qScope', function() {
    return {
      scope: true
    };
  });

  app.directive('ngHoverintent', function() {
    return {
      restrict: 'A',
      scope: true,
      link: function(scope, el, attrs) {
        return require(['library/hoverIntent'], function() {
          var set;
          set = function(el, fn) {
            var $ul;
            if (($ul = el.find('> ul')).length === 1) {
              return el.add($ul)[fn]('over');
            }
          };
          return el.find('li').hoverIntent({
            interval: 5,
            timeout: 100,
            over: function() {
              return set($(this), 'addClass');
            },
            out: function() {
              return set($(this), 'removeClass');
            }
          });
        });
      }
    };
  });

  app.directive('slideshow', [
    '$interval', function($interval) {
      return {
        restrict: 'E',
        scope: true,
        controller: [
          '$scope', function($scope) {
            var autoplayInt;
            $scope.next = function() {
              return $scope.current += 1;
            };
            $scope.prev = function() {
              return $scope.current -= 1;
            };
            $scope.$watch('current', function(nv, ov) {
              if (nv == null) {
                return;
              }
              if (ov === nv) {
                return;
              }
              if (nv > $scope.max - 1) {
                nv = 0;
              }
              if (nv < 0) {
                nv = $scope.max - 1;
              }
              return $scope.current = nv;
            });
            autoplayInt = null;
            $scope.autoplay = function(ms) {
              return autoplayInt = $interval(function() {
                return $scope.next();
              }, ms);
            };
            return $scope.stop = function() {
              return $interval.cancel(autoplayInt);
            };
          }
        ],
        link: function(scope, el, attrs) {
          scope.$slides = el.find('.slide');
          return scope.max = scope.$slides.length || 1;
        }
      };
    }
  ]);

  app.directive('scrollFire', function() {
    return {
      restrict: 'A',
      scope: false,
      link: function(scope, el, attrs) {
        el.on('inview', function(e, visible, x, y) {
          if (visible) {
            return el.removeClass('invisible').addClass('animated fadeInDown');
          }
        });
        return scope.$on('$destroy', function() {
          return el.unbind('inview');
        });
      }
    };
  });

  app.directive('bgParallax', [
    '$timeout', function($timeout) {
      return {
        restrict: 'A',
        scope: false,
        link: function(scope, el, attrs) {
          var setBgPos;
          setBgPos = function() {
            var bg, calc, diff, offset, pos;
            pos = winObj.scrollTop();
            offset = el.offset().top;
            diff = pos - offset;
            calc = diff * .8;
            bg = "center " + calc + "px";
            return el.css({
              backgroundPosition: bg
            });
          };
          $timeout(setBgPos);
          winObj.on('scroll.bp touchmove.bp', setBgPos);
          return scope.$on('$destroy', function() {
            return winObj.unbind('scroll.bp touchmove.bp');
          });
        }
      };
    }
  ]);

  app.directive('fadeParallax', [
    '$timeout', function($timeout) {
      return {
        restrict: 'A',
        scope: false,
        link: function(scope, el, attrs) {
          var setFade;
          setFade = function() {
            return el.css({
              opacity: 1 - (winObj.scrollTop() / 500)
            });
          };
          $timeout(setFade);
          winObj.on('scroll.fp touchmove.fp', setFade);
          return scope.$on('$destroy', function() {
            return winObj.unbind('scroll.fp touchmove.fp');
          });
        }
      };
    }
  ]);

}).call(this);

(function() {
  var app;

  app = angular.module('app.filters', []);

  app.filter('trust', [
    '$sce', function($sce) {
      return function(src) {
        return $sce.trustAsResourceUrl(src);
      };
    }
  ]);

  app.filter('nl2br', function() {
    return function(text) {
      if (text != null) {
        return text.replace(/\n/g, '<br />');
      }
    };
  });

  app.filter('reverse', function() {
    return function(obj) {
      return obj.slice().reverse();
    };
  });

  app.filter('objLength', function() {
    return function(obj) {
      var i, z;
      i = 1;
      for (z in obj) {
        i++;
      }
      return i;
    };
  });

  app.filter('parseUrl', function() {
    var pattern;
    pattern = /(http|ftp|https):\/\/[\w-]+(\.[\w-]+)+([\w.,@?^=%&amp;:\/~+#-]*[\w@?^=%&amp;\/~+#-])?/gi;
    return function(text, target) {
      if (target == null) {
        target = '_blank';
      }
      angular.forEach(text.match(pattern), function(url) {
        return text = text.replace(url, "<a target=" + target + " href=" + url + ">" + url + "</a>");
      });
      return text;
    };
  });

}).call(this);

(function() {
  var app;

  app = angular.module('app.services', []);

  app.config([
    '$httpProvider', function($httpProvider) {
      $httpProvider.defaults.transformRequest = function(data) {
        if (data === void 0) {
          return data;
        }
        return jQuery.param(data);
      };
      $httpProvider.defaults.headers.common["X-Request-With"] = 'XMLHttpRequest';
      return $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded; charset=UTF-8';
    }
  ]);

  app.service('$xhr', [
    '$http', '$q', function($http, $q) {
      return {
        fetch: function(uri, method, params) {
          var config, deferred, x;
          if (method == null) {
            method = 'GET';
          }
          if (params == null) {
            params = {};
          }
          deferred = $q.defer();
          config = {
            method: method,
            url: uri,
            cache: false
          };
          if (method === 'POST') {
            config.dataType = 'json';
            config.data = params;
          }
          x = $http(config);
          x.error(function(data, status) {
            return deferred.reject(data, status);
          });
          x.success(function(response, status, headers, config) {
            var results;
            results = [];
            results.data = response;
            return deferred.resolve(results);
          });
          return deferred.promise;
        }
      };
    }
  ]);

}).call(this);
