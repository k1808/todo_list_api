php 8.1
cp .env.example .env
alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'
sail up -d
sail composer update
sail artisan key:generate
sail artisan storage:link
sail artisan migrate --seed


API:
    Register:
        post: http://localhost:80/api/register/
        headers: Accept-application/json
        body: name-test         
              email-test@i.ua
              password-123  
        Response: token
    Login:
        post: http://localhost:80/api/login/
        headers: Accept-application/json
        email-test@i.ua
        password-123  
        Response: token
    task all:
        get: http://localhost:80/api/tasks-all?status=done&priority=2&title=ddd&description=dolorem&sort=created_at=asc,priority=desc,completedAt=asc
        all parameters are optional
    create tas:
        http://localhost:80/api/create-tasks
        body:
            'title' => 'required|string|max:255',
            'priority' => 'required|integer|max:5|min:0',
            'description' => 'nullable',
            'parent_id'=>'nullable'
       
    update-task:
         http://localhost:80/api/update-tasks/22
        'title' => 'nullable|max:255',
        'priority' => 'nullable|max:5|min:0',
        'description' => 'nullable',
        'parent_id'=>'nullable|min:1',
        'status'=>'nullable',
    deleted-task:
        http://localhost:80/api/del-tasks/22

    
