type HeaderProps = {
  children: React.ReactNode;
  className?: string;
};

const Header = ({ children, className }: HeaderProps) => {
  return (
    <div className={`px-4 pt-10 flex items-center gap-4 justify-start sticky top-0 bg-base-100 z-10 shadow-md ${className}`}>
      {children}
    </div>
  );
};

export default Header;