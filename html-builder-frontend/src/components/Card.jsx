export default function Card({ title, subtitle, children }) {
  return (
    <div className="cardx">
      {title && <h3 className="cardx-title">{title}</h3>}
      {subtitle && <p className="cardx-subtitle">{subtitle}</p>}
      {children}
    </div>
  );
}

