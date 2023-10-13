import { Route, Routes } from 'react-router-dom'; 
import GameStore from '../pages/GameStore';

function Router() {

  return (
    <>
      <Routes>  
          <Route path='/' element={<GameStore />} />
      </Routes>
    </>
  )
}

export default Router