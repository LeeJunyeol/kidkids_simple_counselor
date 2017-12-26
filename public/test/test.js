var assert = require('assert');
describe('Array', function () {
    describe('#indexOf()', function () {
        it('should return -1 when the value is not present', function () {
            assert.equal([1, 2, 3].indexOf(4), -1);
        });
    });
});

describe('비동기 코드 테스트', function () {
    describe('#setTimeout', function () {
        it('2초 이내에 완료되지 않으면 실패', function (done) {
            setTimeout(function () {
                done();
            }, 3000);
        });
    });
});