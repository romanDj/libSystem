let API_ROOT = window.location.protocol+"//"+window.location.hostname+"/v1";

/** Some helpers **/

export class Api {
    static getCookie(name) {
        let matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
        ));
        return matches ? decodeURIComponent(matches[1]) : undefined;
    }

    static setCookie(name, value, options = {}) {
        options = {
            path: '/',
            ...options
        };

        if (options.expires instanceof Date) {
            options.expires = options.expires.toUTCString();
        }

        let updatedCookie = encodeURIComponent(name) + "=" + encodeURIComponent(value);

        for (let optionKey in options) {
            updatedCookie += "; " + optionKey;
            let optionValue = options[optionKey];
            if (optionValue !== true) {
                updatedCookie += "=" + optionValue;
            }
        }

        document.cookie = updatedCookie;
    }

    static deleteCookie(name) {
        this.setCookie(name, "", {
            'max-age': -1
        });
    }

    static async sendq(url, method = 'get', data = null, useToken = true) {
        method = method.toUpperCase();
        let options = {
            url,
            method,
            mode: 'cors',
            headers: {
                //'content-type': 'multipart/form-data'
                'Content-Type': 'application/json',
            }
        };

        if (data) {
            options.body = JSON.stringify(data);
        }

        if (useToken) {
            options.headers.Authorization = `Bearer ${this.getCookie("access_token")}`;
        }

        const res = await fetch(`${API_ROOT}${url}`, options);

        if (res.ok) {
            try {
                return {
                    data: await res.json(),
                    response: res
                };
            } catch (e) {
                return {
                    response: res
                }
            }
        }

        throw {
            data: await res.json(),
            response: res
        };
    }
}

/** Common system api models **/

export const User = {
    login: ({login, password}) => Api.sendq(
        '/user/login',
        'post',
        {login, password},
        false
    ),
    registration: ({login, password, fio}) => Api.sendq(
        '/user/register',
        'post',
        {login, password, fio},
        false
    ),
    profile: () => Api.sendq('/user/profile', 'get')
};

export const Athenaeum = {
    Book: {
        list: () => Api.sendq('/athenaeum/books?expand=author'),
        get: (id) => Api.sendq('/athenaeum/books/' + id + '?expand=author'),
        remove: (id) => Api.sendq('/athenaeum/books/' + id, 'delete'),
        add: ({title, description, author_id}) => Api.sendq(
            '/athenaeum/books',
            'post',
            {title, description, author_id}
        ),
        edit: ({id, title, description, author_id}) => Api.sendq(
            '/athenaeum/books/' + id,
            'put',
            {title, description, author_id}
        )
    },
    Author: {
        list: () => Api.sendq('/athenaeum/authors?expand=books'),
        get: (id) => Api.sendq('/athenaeum/authors/' + id + '?expand=books'),
        remove: (id) => Api.sendq('/athenaeum/authors/' + id, 'delete'),
        add: ({fio, description}) => Api.sendq(
            '/athenaeum/authors',
            'post',
            {fio, description}
        ),
        edit: ({id, fio, description}) => Api.sendq(
            '/athenaeum/authors/' + id,
            'put',
            {fio, description}
        )
    }
};