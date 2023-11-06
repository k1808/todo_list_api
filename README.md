php 8.1
1. cp .env.example .env
2. alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'
3. sail up -d
4. sail composer update
5. sail artisan key:generate
6. sail artisan storage:link
7. sail artisan migrate --seed

<div style="text-indent: 40px;">
API:
    Register:
        post: http://localhost:80/api/register/
        headers: Accept-application/json
        body: name-test         
              email-test@i.ua
              password-123  
        Response: token
</div>
<div style="text-indent: 40px;">
    Login:
        post: http://localhost:80/api/login/
        headers: Accept-application/json
        email-test@i.ua
        password-123  
        Response: token
</div>
<div style="text-indent: 40px;">
    task all:
        get: http://localhost:80/api/tasks-all?status=done&priority=2&title=ddd&description=dolorem&sort=created_at=asc,priority=desc,completedAt=asc
        all parameters are optional
</div>
<div style="text-indent: 40px;">
    create tas:
        http://localhost:80/api/create-tasks
        body:
            'title' => 'required|string|max:255',
            'priority' => 'required|integer|max:5|min:0',
            'description' => 'nullable',
            'parent_id'=>'nullable'
</div>
<div style="text-indent: 40px;">       
    update-task:
         http://localhost:80/api/update-tasks/22
        'title' => 'nullable|max:255',
        'priority' => 'nullable|max:5|min:0',
        'description' => 'nullable',
        'parent_id'=>'nullable|min:1',
        'status'=>'nullable',
</div>
<div style="text-indent: 40px;">
    deleted-task:
        http://localhost:80/api/del-tasks/22

</div>
