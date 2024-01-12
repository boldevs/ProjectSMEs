const guest = ({ next, router }) => {
    if (!localStorage.getItem('token')) {
        return next();
    }
    
    return router.push({ path: '/' });
};

export default guest;