import { Route, Routes } from 'react-router-dom'; 
import Users from '../pages/Users';

function Router() {

  return (
    <>
      <Routes>  
        {
          <>
            <Route path='/users' element={<Users />} />
          </>
        }
      </Routes>
    </>
  )
}

export default Router