const getJwtPayload = jwt => {
    try {
        const parts = jwt.split('.');
        if (parts.length !== 3) {
            // a naive way to detect non-JWTs
            return null;
        }

        // Note: signature is ignored – the same way as for basic auth we don't check the password
        // It could be a good idea to check if the token is encrypted to prevent unnecessary processing
        return JSON.parse(Buffer.from(parts[1], 'base64url').toString());
    } catch (err) {
        return null;
    }
};

const parse = {
    /** @param {string} jwt */
    bearer: jwt => {
        const parsedJwt = getJwtPayload(jwt);
        if (!parsedJwt) {
            return null;
        }

        return parsedJwt.sub ?? parsedJwt.clientId;
    },
    /** @param {string} base64encodedCredentials */
    basic: (base64encodedCredentials) => {
        const usernameAndPassword = atob(base64encodedCredentials).split(':');
        if (!usernameAndPassword || usernameAndPassword.length !== 2) {
            return null;
        }

        return usernameAndPassword[0];
    },
};

export default {
    getUser: vars => {
        if (!vars.header_authorization) {
            return null;
        }

        const parts = vars.header_authorization.split(' ');
        /** @type {(keyof parse)} */
        const type = parts.shift().toLowerCase();
        if (!(type in parse)) {
            return null;
        }

        return parse[type].apply(null, parts);
    },
};
