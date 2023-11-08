import { Route, Routes } from 'react-router-dom'; 
import GameStore from '../pages/GameStore';
import PaymentTransactions from '../pages/PaymentTransactions';

function Router() {

  return (
    <>
      <Routes>  
          <Route path='/' element={<GameStore />} />
          <Route path='/payment' element={<PaymentTransactions />} />
      </Routes>
    </>
  )
}

export default Router