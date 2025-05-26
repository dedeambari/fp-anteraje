const Footer = () => {
  const route = window.location.pathname;
  return (
    route === "/login" || route === "/forgot-password" || route === "/verify-otp" || route === "/reset-password" ? (
      <footer className="text-white px-4">
        <p className="text-center">&copy; {new Date().getFullYear()} AntarAje.</p>
      </footer>
    ) : (<footer className="footer footer-center p-4 text-gray-600 font-semibold">
      <aside>
        <p className="text-center">&copy; {new Date().getFullYear()} AntarAje.</p>
      </aside>
    </footer>)
  );
};

export default Footer;