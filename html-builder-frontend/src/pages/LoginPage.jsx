import { useState } from "react";
import { useNavigate } from "react-router-dom";
import Card from "../components/Card";
import Input from "../components/Input";
import Button from "../components/Button";

export default function LoginPage() {
  const nav = useNavigate();
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");

  function onSubmit(e){
    e.preventDefault();

    nav("/");
  }

  return (
    <div className="container" style={{maxWidth:420, marginTop:60}}>
      <Card title="Login" subtitle="Uloguj se da vidiš nivoe i leaderboard">
        <form onSubmit={onSubmit}>
          <Input label="Email" value={email} onChange={(e)=>setEmail(e.target.value)} />
          <Input label="Lozinka" type="password" value={password} onChange={(e)=>setPassword(e.target.value)} />
          <div style={{marginTop:14}}>
            <Button type="submit">Uloguj se</Button>
          </div>
        </form>
      </Card>
    </div>
  );
}
