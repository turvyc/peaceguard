//
//  User.m
//
//  Contributor(s): Ashley Lesperance
//
//  Copyright (c) 2013 Number 13 Developer's Group
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
