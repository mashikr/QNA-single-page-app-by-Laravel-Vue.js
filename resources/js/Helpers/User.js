import Token from './Token';
import AppStorage from './AppStorage';

class User {

    responseAfterToken(response) {
        const access_token = response.data.access_token;
        const username = response.data.user;

        if(Token.isValid(access_token)) {
            AppStorage.store(username, access_token);
        }
    }

    hasToken() {
        const storeToken = AppStorage.getToken();

        if(storeToken) {
            return Token.isValid(storeToken) ? true : this.logout();
        }

        return false;
    }

    loggedIn() {
        return this.hasToken();
    }

    logout() {
        AppStorage.clear();
        window.location = '/';
    }

    name() {
        if(this.loggedIn()) {
            return AppStorage.getUser();
        }
    }

    id() {
        if(this.loggedIn()) {
            const payload = Token.payload(AppStorage.getToken());
            return payload.sub;
        }
        return 0;
    }

    own(id) {
        return this.id() == id;
    }

}

export default User;