export function getToken() {
  return localStorage.getItem("auth_token");
}

export function getUser() {
  const u = localStorage.getItem("auth_user");
  return u ? JSON.parse(u) : null;
}

export function isLoggedIn() {
  return !!getToken();
}

export function hasRole(roles = []) {
  const user = getUser();
  if (!user) return false;
  return roles.includes(user.tip_korisnika);
}

export function logout() {
  localStorage.removeItem("auth_token");
  localStorage.removeItem("auth_user");
}
