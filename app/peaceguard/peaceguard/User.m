//
//  User.m
//  peaceguard
//
//  Created by Lesperance Ashley on 2013-02-15.
//  Copyright (c) 2013 Ashley Lesperance. All rights reserved.
//

#import "User.h"

@implementation User

//Custon initializer
-(id)initWithUsername:(NSString *)username password:(NSString *)password
{
    self = [super init];
    if (self){
        _username = username;
        _password = password;
        _authenticated = NO;
        return self;
    }
    return nil;
}

@end
