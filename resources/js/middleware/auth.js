const auth = ({ next, router }) => {
    if (!localStorage.getItem('token')) {
        return router.push("/login");
    }

    return next();
};

export default auth;