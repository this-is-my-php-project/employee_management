
// status code is 200
pm.test("Status code is 200", function () {
    // pm must not have jsonData.status
    var jsonData = pm.response.json();
    // if jsonData have status or not
    if (jsonData.status) {
        //pm return fail
    }

    pm.expect(jsonData.status).to.equal(200);
});