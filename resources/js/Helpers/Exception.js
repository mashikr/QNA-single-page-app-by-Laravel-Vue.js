class Exception {
    handle(error) {
        this.isExpired(error.response.data);
    }

    isExpired(error) {
        if(error == 'Token has expired') {
            _User.logout();
        }
    }
}

export default Exception;