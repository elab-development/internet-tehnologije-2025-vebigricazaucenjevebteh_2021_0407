import { Navigate } from "react-router-dom";
import { isLoggedIn, hasRole } from "../utils/auth";



export default function ProtectedRoute({ children, roles }) {
  if (!isLoggedIn()) {
    return <Navigate to="/login" replace />;
  }

  if (roles && !hasRole(roles)) {
    return <Navigate to="/" replace />;
  }

  return children;
}

